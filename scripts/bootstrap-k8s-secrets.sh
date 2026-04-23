#!/usr/bin/env bash
# ---------------------------------------------------------------------------
# bootstrap-k8s-secrets.sh
#
# Creates the two Secrets required by the TrustFlow CRM K8s manifests:
#   - trustflow-secrets (APP_KEY, DB_USERNAME, DB_PASSWORD, OPENAI_API_KEY)
#   - mysql-secrets     (MYSQL_ROOT_PASSWORD, MYSQL_USER, MYSQL_PASSWORD,
#                        MYSQL_DATABASE)
#
# Idempotent: re-running does NOT overwrite existing Secrets. To rotate, run
#   kubectl -n trustflow delete secret trustflow-secrets mysql-secrets
# and then re-run this script.
#
# Usage:
#   ./scripts/bootstrap-k8s-secrets.sh                 # auto-generate APP_KEY
#   APP_KEY=base64:xxx DB_PASSWORD=... \
#     OPENAI_API_KEY=sk-... ./scripts/bootstrap-k8s-secrets.sh
# ---------------------------------------------------------------------------
set -euo pipefail

NS="trustflow"

require_cmd() {
  command -v "$1" >/dev/null 2>&1 || { echo "error: '$1' not found in PATH" >&2; exit 1; }
}

require_cmd kubectl
require_cmd openssl

CTX=$(kubectl config current-context 2>/dev/null || true)
echo "Current kube-context: ${CTX:-<none>}"
if [ "${CTX:-}" != "docker-desktop" ]; then
  read -r -p "Switch to docker-desktop context? [y/N] " yn
  [[ "${yn:-}" =~ ^[Yy]$ ]] && kubectl config use-context docker-desktop
fi

# Namespace
kubectl apply -f "$(dirname "$0")/../k8s/namespace.yaml"

# ---------------------------------------------------------------------------
# trustflow-secrets
# ---------------------------------------------------------------------------
if kubectl -n "$NS" get secret trustflow-secrets >/dev/null 2>&1; then
  echo "trustflow-secrets already exists — skipping (delete it to recreate)."
else
  APP_KEY="${APP_KEY:-base64:$(openssl rand -base64 32)}"
  DB_USERNAME="${DB_USERNAME:-trustflow}"
  DB_PASSWORD="${DB_PASSWORD:-trustflow_local_pw}"
  OPENAI_API_KEY="${OPENAI_API_KEY:-sk-local-placeholder}"

  kubectl -n "$NS" create secret generic trustflow-secrets \
    --from-literal=APP_KEY="$APP_KEY" \
    --from-literal=DB_USERNAME="$DB_USERNAME" \
    --from-literal=DB_PASSWORD="$DB_PASSWORD" \
    --from-literal=OPENAI_API_KEY="$OPENAI_API_KEY"
  echo "trustflow-secrets created."
fi

# ---------------------------------------------------------------------------
# mysql-secrets (root + app user must match DB_PASSWORD above)
# ---------------------------------------------------------------------------
if kubectl -n "$NS" get secret mysql-secrets >/dev/null 2>&1; then
  echo "mysql-secrets already exists — skipping."
else
  # Pull DB_PASSWORD from trustflow-secrets so both stay in sync.
  DB_PASSWORD_B64=$(kubectl -n "$NS" get secret trustflow-secrets \
    -o jsonpath='{.data.DB_PASSWORD}')
  DB_PASSWORD=$(echo "$DB_PASSWORD_B64" | base64 -d)

  kubectl -n "$NS" create secret generic mysql-secrets \
    --from-literal=MYSQL_ROOT_PASSWORD="$DB_PASSWORD" \
    --from-literal=MYSQL_USER="trustflow" \
    --from-literal=MYSQL_PASSWORD="$DB_PASSWORD" \
    --from-literal=MYSQL_DATABASE="trustflow_crm"
  echo "mysql-secrets created."
fi

echo ""
echo "Secrets in namespace '${NS}':"
kubectl -n "$NS" get secrets
