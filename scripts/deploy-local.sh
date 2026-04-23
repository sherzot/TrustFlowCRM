#!/usr/bin/env bash
# ---------------------------------------------------------------------------
# deploy-local.sh
#
# Manual deploy helper — same flow as .github/workflows/deploy.yml JOB 3,
# but run directly from your Mac. Useful when you want to deploy without
# going through GitHub (e.g., testing uncommitted k8s/ changes).
#
# Prerequisites:
#   - Docker Desktop Kubernetes enabled
#   - Current kube-context == docker-desktop
#   - Image sherdev/trustflow-crm:<tag> already pushed to Docker Hub
#     (or exists locally in the docker-desktop node)
#
# Usage:
#   ./scripts/deploy-local.sh                  # deploys :latest
#   ./scripts/deploy-local.sh sha-abcdef1       # deploys a specific sha tag
# ---------------------------------------------------------------------------
set -euo pipefail

TAG="${1:-latest}"
IMAGE="sherdev/trustflow-crm:${TAG}"
NS="trustflow"

here() { cd "$(dirname "$0")/.." && pwd; }
REPO_ROOT="$(here)"
cd "$REPO_ROOT"

echo "==> Using image: ${IMAGE}"

CTX=$(kubectl config current-context)
if [ "$CTX" != "docker-desktop" ]; then
  echo "Current context is '$CTX' — switching to docker-desktop"
  kubectl config use-context docker-desktop
fi

echo "==> Bootstrapping Secrets (no-op if they already exist)"
./scripts/bootstrap-k8s-secrets.sh

echo "==> Applying k8s/ via kustomize"
kubectl apply -k k8s/

echo "==> Pinning trustflow-web to ${IMAGE}"
kubectl -n "$NS" set image deployment/trustflow-web "app=${IMAGE}"

echo "==> Waiting for rollout"
kubectl -n "$NS" rollout status deployment/trustflow-web --timeout=300s

echo "==> Running migrations Job"
kubectl -n "$NS" delete job trustflow-migrate --ignore-not-found
sed "s#IMAGE_PLACEHOLDER#${IMAGE}#g" k8s/migration-job.yaml | kubectl apply -f -
kubectl -n "$NS" wait --for=condition=complete --timeout=300s job/trustflow-migrate || {
  echo "Migration failed. Logs:"
  kubectl -n "$NS" logs job/trustflow-migrate --tail=200 || true
  exit 1
}
kubectl -n "$NS" logs job/trustflow-migrate --tail=80 || true

echo ""
echo "==> Smoke test"
for i in $(seq 1 20); do
  if curl -fsS --max-time 5 http://localhost:30080/up >/dev/null; then
    echo "OK: http://localhost:30080/up"
    break
  fi
  echo "waiting ($i/20)..."; sleep 3
done

echo ""
echo "Deploy complete."
echo "  URL:    http://localhost:30080"
echo "  Image:  ${IMAGE}"
kubectl -n "$NS" get pods -o wide
