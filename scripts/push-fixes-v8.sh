#!/usr/bin/env bash
# ----------------------------------------------------------------------------
# TrustFlow CRM — v8 hotfix: NodePort → port-forward for smoke test
#
# Context: after v7 the migration step goes green but the final smoke test
# (curl http://localhost:30080/up) fails. Diagnosis:
#
#   Web pod:          1/1 Running, healthy
#   Service:          NodePort 80:30080/TCP
#   Endpoints:        10.244.0.17:8080  (correctly populated)
#   In-cluster probe: returns 200 OK for /index.php (nginx/fpm healthy)
#   Host-side curl:   connect to 127.0.0.1:30080 refused
#                     connect to ::1:30080 refused
#
# Docker Desktop's Kubernetes does not reliably expose NodePort services on
# `localhost` from the Mac host. This is a well-known quirk of the Docker
# Desktop + K8s combo; the NodePort binds inside the VM but the host
# port-mapping back to the Mac is flaky, especially right after the Service
# is recreated by a kustomize apply.
#
# Fix:
#   1. Smoke test now goes through `kubectl port-forward svc/trustflow-web
#      38080:80` instead of hitting NodePort 30080 directly. This tests the
#      Service (not just the Pod) and is independent of Docker Desktop's
#      NodePort binding behavior.
#   2. A new scripts/pf.sh helper lets you open the app locally whenever you
#      want (just `bash scripts/pf.sh`, leave it running, open the browser).
#   3. Deploy summary now tells you how to reach the app.
#
# Run from the repo root on your Mac:
#     bash scripts/push-fixes-v8.sh
# ----------------------------------------------------------------------------
set -euo pipefail

REPO_ROOT="$(git rev-parse --show-toplevel)"
cd "$REPO_ROOT"

echo "==> Repo:   $REPO_ROOT"
echo "==> Branch: $(git rev-parse --abbrev-ref HEAD)"
echo "==> HEAD:   $(git --no-pager log --oneline -1)"
echo

if [ -f .git/index.lock ]; then
    echo "==> Removing stale .git/index.lock"
    rm -f .git/index.lock
fi

BRANCH="$(git rev-parse --abbrev-ref HEAD)"
if [ "$BRANCH" != "main" ]; then
    echo "ERROR: expected 'main', got '$BRANCH'. Aborting."
    exit 1
fi

echo "==> Files that will be committed:"
for f in \
    .github/workflows/deploy.yml \
    scripts/pf.sh \
    scripts/push-fixes-v8.sh
do
    if [ ! -e "$f" ]; then
        echo "    MISSING: $f  <-- ABORT"
        exit 1
    fi
    echo "    $f"
done
echo

read -p "Commit + push v8 (port-forward smoke test)? [y/N] " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Aborted. No changes made."
    exit 1
fi

git add .github/workflows/deploy.yml scripts/pf.sh scripts/push-fixes-v8.sh

chmod +x scripts/pf.sh

git commit -m "fix(ci): smoke-test via kubectl port-forward instead of NodePort

After the v7 macOS-timeout hotfix the Migration Job now goes green,
but the deploy still fails at the smoke-test step because the NodePort
(30080 on Service trustflow-web) does not bind on the Mac host. From
the runner:

    curl -v http://localhost:30080/up
    * connect to 127.0.0.1 port 30080 refused
    * connect to ::1 port 30080 refused

The cluster itself is healthy — svc/trustflow-web has a populated
endpoint (10.244.0.17:8080), nginx inside the pod returns 200 for
/index.php — but Docker Desktop does not reliably expose NodePort
services on localhost from the Mac host, especially right after the
Service is recreated via kustomize apply.

Switch the smoke test to use 'kubectl port-forward svc/trustflow-web
38080:80' in the background, wait for the listener, curl, clean up.
This tests the Service (not just the Pod) and is independent of how
the host exposes NodePorts — so it also works unchanged on any
future runner that does or doesn't proxy NodePort to localhost.

Add scripts/pf.sh so the browser-access flow is 'bash scripts/pf.sh',
matching the CI approach. Update the deploy summary to tell the user
how to reach the app locally (NodePort 30080 stays defined on the
Service so Ingress/LoadBalancer overlays can still consume it in
higher environments, but localhost access on Docker Desktop goes
through port-forward)."

echo
echo "==> New commit:"
git --no-pager log --oneline -3
echo
echo "==> Pushing to origin/main…"
git push origin main

echo
echo "==> DONE."
echo
echo "Next steps:"
echo "  1. Wait for Actions to go green:"
echo "       https://github.com/sherzot/TrustFlowCRM/actions"
echo "  2. Open the app locally in one terminal:"
echo "       bash scripts/pf.sh"
echo "     then open http://localhost:30080/admin in your browser."
