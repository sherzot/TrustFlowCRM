# TrustFlow CRM — Deployment Overview

_Last updated: 2026-04-24_

## TL;DR

| Environment | Stack | Entry point |
| --- | --- | --- |
| Local dev | `docker-compose.yml` (builds locally) | http://localhost:18080 |
| CI (GitHub Actions) | Test → Build → Push image | `ghcr.io/sherzot/trustflowcrm` |
| Production (future) | `docker-compose.prod.yml` (pulls image) | `bash scripts/deploy.sh` on any Linux host |

Kubernetes has been shelved — see the section at the bottom.

## Local development

Your daily loop has not changed. From the repo root:

```bash
docker compose up -d --build
docker compose exec app php artisan migrate --seed
open http://localhost:18080
```

Services exposed:

- App — http://localhost:18080
- Adminer (DB browser) — http://localhost:18081
- Mailpit (mail sink UI) — http://localhost:18025

## CI/CD

On every push to `main` (and on `workflow_dispatch`), GitHub Actions runs
`.github/workflows/deploy.yml`:

1. **Test (PHPUnit)** — runs on `ubuntu-latest` with MySQL 8 + Redis 7
   as services. Currently `continue-on-error: true` (informational, not
   blocking). Flip that back to `false` once the suite is reliable.
2. **Build & Push (GHCR)** — builds the Docker image (`linux/amd64`)
   and pushes it to `ghcr.io/sherzot/trustflowcrm` with three tags:
   - `:latest` — the most recent main build
   - `:main` — same, pinned by branch
   - `:sha-<short>` — immutable, use this for deterministic deploys

The build uses `GITHUB_TOKEN` for GHCR auth — no manual secret setup
needed. The workflow declares `permissions: packages: write`, which is
all GHCR requires.

### Visibility

The image is private by default (inherits repo visibility). To pull it
from a deploy host:

```bash
echo "$GHCR_TOKEN" | docker login ghcr.io -u sherzot --password-stdin
docker pull ghcr.io/sherzot/trustflowcrm:latest
```

`$GHCR_TOKEN` is a GitHub personal access token (classic) with
`read:packages` scope, or the deploy target's own machine-user token.

To make the image public (simpler, no login needed on deploy hosts):
GitHub → repo → Packages → `trustflowcrm` → Settings → Change visibility.

## Production deploy (cloud VM / VPS)

Target shape: any Linux host with Docker + the Compose plugin. This
works identically on AWS EC2, DigitalOcean droplets, Hetzner Cloud,
Linode, Fly.io machines that support compose, or a Raspberry Pi.

One-time per host:

```bash
git clone https://github.com/sherzot/TrustFlowCRM.git
cd TrustFlowCRM
cp .env.production.example .env.production
# edit .env.production — APP_KEY, DB_PASSWORD, MYSQL_*, OPENAI_API_KEY, …
# if the image is still private:
echo "$GHCR_TOKEN" | docker login ghcr.io -u sherzot --password-stdin
```

To deploy or upgrade:

```bash
bash scripts/deploy.sh                        # :latest
IMAGE_TAG=sha-abc1234 bash scripts/deploy.sh  # pinned
```

What `scripts/deploy.sh` does:

1. `docker compose pull` — fetch the new image
2. bring up `db` + `redis` first and wait for db to be healthy
3. run `php artisan migrate --force` in a one-shot container
4. bring up `app` (rolls forward if it was already running)
5. wait for the app's healthcheck to return healthy

The healthcheck uses PHP (`file_get_contents` against `/up`) so it
works regardless of what utilities the base image ships.

### Putting TLS in front

Don't expose the app port directly to the internet. Run Caddy, nginx,
or Traefik on the same host, terminate TLS there, and proxy to
`127.0.0.1:${APP_PORT:-8080}`. The Caddyfile for a simple setup:

```caddy
yourdomain.com {
    reverse_proxy 127.0.0.1:8080
}
```

### Platform variants

- **Railway / Fly.io** — they honor `docker-compose.prod.yml` with
  minor tweaks (remove the host port mapping, let the platform route
  to container:8080). Managed MySQL + Redis add-ons let you drop the
  `db` / `redis` services from compose and point Laravel's env at the
  add-on URIs.
- **AWS ECS / Fargate** — use the GHCR image directly in a task
  definition. Back it with RDS MySQL + ElastiCache Redis. Compose is
  not used; the `.env.production` values become task environment
  variables + secrets.
- **Single VPS** — use this compose stack as-is. Simplest path. Good
  for the first ~10k users.

## Shelved: Kubernetes

The repo contains `k8s/` manifests and some helper scripts
(`scripts/pf.sh`, `scripts/push-fixes-v7.sh`, `scripts/push-fixes-v8.sh`)
from an earlier phase where CI deployed to Docker Desktop's built-in
Kubernetes on an Apple Silicon Mac via a self-hosted runner.

Why it was retired (2026-04-24):

- Docker Desktop K8s is a development sandbox, not a production target.
  Every CI failure we debugged in that phase was an environment quirk,
  not an application bug:
  - QEMU emulation of `linux/amd64` pushed build time past 50 minutes.
  - macOS self-hosted runners don't ship GNU `timeout` by default, so
    a `timeout 330 kubectl wait …` wrapper silently exited 127 and
    reported a successful Job as failed.
  - NodePort services don't reliably bind to the Mac host's
    `localhost`, so post-deploy smoke tests failed even when the pod
    was healthy in-cluster.
- The app is a single-developer project with no production traffic
  yet. Kubernetes' value proposition (horizontal scaling, multi-node
  scheduling, rolling deploys across a fleet) does not apply here.
- Docker Compose covers the same deploy shape with 10% of the
  operational surface.

The `k8s/` folder and the old push helpers stay in the tree (never
delete without explicit approval). They are not exercised by CI. If and
when a real K8s target appears — managed EKS / GKE / DOKS, or a
multi-node bare-metal cluster — we can revive them with real fixes
(Ingress instead of NodePort, a proper build runner, etc).

Until then: docker-compose is the deploy story.
