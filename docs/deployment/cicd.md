# CI/CD — Push-to-deploy Pipeline

> **Pipeline:** `git push origin main` → **Test (cloud)** → **Build & Push (cloud)** → **Deploy (self-hosted Mac → Docker Desktop K8s)** → `http://localhost:30080`

This doc is the runbook for the unified pipeline defined in
[`.github/workflows/deploy.yml`](../../.github/workflows/deploy.yml).
It targets the **local Docker Desktop Kubernetes** cluster on Sher's Mac as
the deploy environment. For staging / production, add a kustomize overlay
under `k8s/overlays/<env>/` and a matching deploy job.

---

## Architecture

```
┌──────────────────────┐        ┌──────────────────────┐
│  git push origin main │───────▶│ GitHub Actions (cloud)│
└──────────────────────┘        └──────────────────────┘
                                     │
                                     ├── JOB 1: test
                                     │   PHPUnit + MySQL 8 + Redis 7 (service containers)
                                     │
                                     ├── JOB 2: build
                                     │   Docker Buildx → Docker Hub
                                     │   sherdev/trustflow-crm:latest
                                     │   sherdev/trustflow-crm:sha-<short>
                                     │
                                     └── JOB 3: deploy  (self-hosted runner)
                                         ┌──────────────────────────────────┐
                                         │ Sher's Mac (runner: Anonymous)   │
                                         │                                   │
                                         │  kubectl config use docker-desktop│
                                         │  kubectl apply -k k8s/            │
                                         │  kubectl set image ...            │
                                         │  kubectl rollout status ...       │
                                         │  kubectl apply migration-job.yaml │
                                         │  curl http://localhost:30080/up   │
                                         │                                   │
                                         │  ──▶ Docker Desktop Kubernetes    │
                                         │       NodePort 30080              │
                                         │       NS: trustflow               │
                                         └──────────────────────────────────┘
```

---

## Required GitHub Secrets

Configured at **Settings → Secrets and variables → Actions** on the GitHub
repo.

| Name | Purpose | Required |
| --- | --- | --- |
| `DOCKER_USERNAME` | Docker Hub username (`sherdev`) | yes |
| `DOCKER_PASSWORD` | Docker Hub Access Token (not your password) | yes |
| `APP_KEY` | Laravel `APP_KEY`; pasted as `base64:...`. Auto-generated on first deploy if unset. | optional |
| `K8S_DB_PASSWORD` | MySQL password for the `trustflow` user. Defaults to `trustflow_local_pw` if unset (LOCAL ONLY). | optional |
| `OPENAI_API_KEY` | For the AI service layer. Optional for local. | optional |

Generate a Docker Hub Access Token at
[hub.docker.com → Account Settings → Security → New Access Token](https://hub.docker.com/settings/security).

Generate an `APP_KEY` value locally with:

```bash
php artisan key:generate --show
```

---

## Self-hosted Runner (Sher's Mac)

The deploy job runs on the self-hosted runner installed at `~/actions-runner`.

**Runner properties:**

| Field | Value |
| --- | --- |
| Name | `Anonymous` |
| Labels | `self-hosted`, `macOS`, `ARM64` |
| Service | `actions.runner.sherzot-TrustFlowCRM.Anonymous` |
| launchd plist | `~/Library/LaunchAgents/actions.runner.sherzot-TrustFlowCRM.Anonymous.plist` |
| Managed by | `~/actions-runner/svc.sh` |

**Service management:**

```bash
cd ~/actions-runner
./svc.sh status        # check
./svc.sh stop
./svc.sh start
./svc.sh uninstall     # remove the launchd service
```

**Prerequisites on the Mac** (verified at pipeline start):

- `kubectl` v1.28+ with `docker-desktop` context
- Docker Desktop with Kubernetes enabled
- `curl`, `git`, `bash`

**To reinstall the runner from scratch:**

```bash
cd ~/actions-runner
./svc.sh stop
./svc.sh uninstall
./config.sh remove --token <NEW_REGISTRATION_TOKEN>
# Then re-run the steps from https://github.com/sherzot/TrustFlowCRM/settings/actions/runners/new
```

---

## First-time deploy

The pipeline is idempotent and auto-provisions everything it needs, but on a
brand-new cluster you can also run the bootstrap manually:

```bash
# 1) Confirm cluster
kubectl config use-context docker-desktop
kubectl get nodes

# 2) Create namespace + Secrets
./scripts/bootstrap-k8s-secrets.sh

# 3) Apply base manifests
kubectl apply -k k8s/

# 4) Wait for MySQL + Redis
kubectl -n trustflow rollout status statefulset/mysql --timeout=180s
kubectl -n trustflow rollout status deployment/redis  --timeout=120s

# 5) First migration (replace IMAGE_PLACEHOLDER with :latest)
sed "s#IMAGE_PLACEHOLDER#sherdev/trustflow-crm:latest#g" \
  k8s/migration-job.yaml | kubectl apply -f -
kubectl -n trustflow wait --for=condition=complete \
  --timeout=300s job/trustflow-migrate

# 6) Seed (optional, one-off)
POD=$(kubectl -n trustflow get pods -l app.kubernetes.io/name=trustflow-web \
  -o jsonpath='{.items[0].metadata.name}')
kubectl -n trustflow exec -it "$POD" -- php artisan db:seed --force

# 7) Smoke
curl -s http://localhost:30080/up && echo OK
open http://localhost:30080
```

---

## Typical push-to-deploy flow

```bash
# on your laptop
git checkout main
git pull
# make changes...
git add .
git commit -m "feat(crm): <what changed>"
git push origin main
```

Then watch:

1. **GitHub → Actions tab** — the `CI/CD — Test → Build → Deploy` workflow runs
   - `test` job turns green
   - `build` job pushes image tags
   - `deploy` job runs on your Mac
2. **Docker Hub** — new tag `sha-<short>` appears under `sherdev/trustflow-crm`
3. **Your Mac** — pods roll to the new image
4. **http://localhost:30080** — new version is live

---

## Manual deploy (no GitHub)

When you want to test k8s/ changes without committing:

```bash
./scripts/deploy-local.sh             # deploys :latest
./scripts/deploy-local.sh sha-abc1234  # deploys a specific tag
```

This is the same flow as the deploy job, but runs locally against
`sherdev/trustflow-crm:<tag>` pulled from Docker Hub.

---

## Troubleshooting

### `deploy` job never starts / stays queued
The self-hosted runner is offline. Check:
```bash
cd ~/actions-runner && ./svc.sh status
```
and restart if needed. Verify in **Settings → Actions → Runners** that
`Anonymous` is **Idle** (green).

### `kubectl apply` fails with "the server could not find the requested resource"
Wrong context. The pipeline auto-switches, but if you're running manually:
```bash
kubectl config use-context docker-desktop
```

### MySQL pod stays `Pending`
Docker Desktop storage driver issue. Check:
```bash
kubectl -n trustflow describe pvc data-mysql-0
```
If the PVC is stuck `Pending`, restart Docker Desktop from the menu bar.

### App pod CrashLoopBackOff
```bash
kubectl -n trustflow logs deployment/trustflow-web --tail=200 --previous
```
Most common cause on first boot: MySQL not ready yet. The `startupProbe`
gives 5 minutes; if it's still failing, delete the pod to retry:
```bash
kubectl -n trustflow delete pod -l app.kubernetes.io/name=trustflow-web
```

### Migrations fail: `SQLSTATE[HY000] [1045] Access denied`
`trustflow-secrets.DB_PASSWORD` does not match `mysql-secrets.MYSQL_PASSWORD`.
Rotate both together:
```bash
kubectl -n trustflow delete secret trustflow-secrets mysql-secrets
./scripts/bootstrap-k8s-secrets.sh
kubectl -n trustflow delete statefulset/mysql      # recreates the DB
kubectl -n trustflow delete pvc data-mysql-0       # WIPES DATA — local only
```

### Image pull fails on the Mac
Docker Desktop occasionally loses its registry credentials. From a terminal:
```bash
docker login                  # re-enter sherdev token
docker pull sherdev/trustflow-crm:latest
```

### Rollback to previous image
```bash
kubectl -n trustflow rollout undo deployment/trustflow-web
# or pin manually:
kubectl -n trustflow set image deployment/trustflow-web \
  app=sherdev/trustflow-crm:sha-<older-sha>
```

---

## Files

| Path | Purpose |
| --- | --- |
| `.github/workflows/deploy.yml` | The pipeline itself |
| `k8s/kustomization.yaml` | Base kustomize entry point |
| `k8s/namespace.yaml` | `trustflow` namespace |
| `k8s/configmap.yaml` | Non-secret env |
| `k8s/mysql.yaml` | MySQL StatefulSet + Service + PVC |
| `k8s/redis.yaml` | Redis Deployment + Service |
| `k8s/deployment.yaml` | `trustflow-web` Deployment |
| `k8s/service.yaml` | NodePort 30080 |
| `k8s/migration-job.yaml` | One-off `php artisan migrate` Job |
| `k8s/hpa.yaml` | (optional) HorizontalPodAutoscaler |
| `k8s/ingress.yaml` | (optional, staging+prod only) Ingress |
| `scripts/bootstrap-k8s-secrets.sh` | Create `trustflow-secrets` + `mysql-secrets` |
| `scripts/deploy-local.sh` | Manual deploy (same flow as JOB 3) |

---

## Promotion path (future)

When a real cluster is ready, add an overlay:

```
k8s/
├── (base — current files)
└── overlays/
    ├── staging/
    │   ├── kustomization.yaml
    │   ├── configmap-patch.yaml    # APP_URL, APP_ENV=staging
    │   └── ingress.yaml
    └── production/
        ├── kustomization.yaml
        ├── configmap-patch.yaml
        └── ingress.yaml
```

Then add `deploy-staging` and `deploy-production` jobs to `deploy.yml`,
running on separate self-hosted or OIDC-authed cloud runners with
`kubectl apply -k k8s/overlays/<env>/`.
