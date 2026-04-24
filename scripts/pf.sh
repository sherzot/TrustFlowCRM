#!/usr/bin/env bash
# ----------------------------------------------------------------------------
# TrustFlow CRM — port-forward helper
#
# Docker Desktop's Kubernetes does not reliably expose NodePort 30080 on
# `localhost` from the Mac host — the binding is flaky, especially right
# after the Service is recreated. Instead of fighting that, we run a
# persistent port-forward.
#
# Usage:
#     bash scripts/pf.sh           # binds localhost:30080 -> svc/trustflow-web
#     bash scripts/pf.sh 3000      # binds localhost:3000
#
# Leave this terminal running and open http://localhost:<port>/admin in
# another window. Ctrl-C in this terminal to stop forwarding.
# ----------------------------------------------------------------------------
set -euo pipefail

PORT="${1:-30080}"

echo "==> Verifying cluster context…"
CONTEXT=$(kubectl config current-context 2>/dev/null || echo "")
if [ "$CONTEXT" != "docker-desktop" ]; then
    echo "WARNING: kubectl context is '${CONTEXT}', expected 'docker-desktop'."
    echo "         Run: kubectl config use-context docker-desktop"
fi

echo "==> Checking that svc/trustflow-web has endpoints…"
EP=$(kubectl -n trustflow get endpoints trustflow-web -o jsonpath='{.subsets[0].addresses[0].ip}' 2>/dev/null || echo "")
if [ -z "$EP" ]; then
    echo "ERROR: svc/trustflow-web has no endpoints. Is the web pod Ready?"
    kubectl -n trustflow get pods -l app.kubernetes.io/name=trustflow-web -o wide
    exit 1
fi
echo "    endpoint: ${EP}:8080"

# Free the port if something else is holding it.
if lsof -i ":${PORT}" -sTCP:LISTEN >/dev/null 2>&1; then
    echo "ERROR: port ${PORT} is already in use on localhost."
    echo "       Pick a different port: bash scripts/pf.sh <PORT>"
    lsof -i ":${PORT}" -sTCP:LISTEN
    exit 1
fi

echo "==> Forwarding localhost:${PORT} -> svc/trustflow-web:80"
echo "    Open http://localhost:${PORT}/admin in your browser."
echo "    Ctrl-C to stop."
echo

exec kubectl -n trustflow port-forward svc/trustflow-web "${PORT}:80"
