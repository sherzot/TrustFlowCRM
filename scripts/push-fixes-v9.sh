#!/usr/bin/env bash
# ----------------------------------------------------------------------------
# TrustFlow CRM — v9: retire Kubernetes deploy, adopt docker-compose + GHCR
#
# Context: after shipping v6/v7/v8 CI fixes we saw that every failure on
# the self-hosted macOS runner + Docker Desktop K8s path was an
# environment quirk (QEMU build time, missing GNU `timeout`, flaky
# NodePort-to-localhost binding) — not an application bug. For a
# single-developer, no-production-traffic project, Kubernetes on Docker
# Desktop is all cost, no benefit.
#
# v9 simplifies:
#   - Pipeline becomes Test → Build → Push(GHCR). No deploy job.
#   - New docker-compose.prod.yml pulls the image and runs on any Linux
#     host (VPS, AWS EC2, Railway/Fly, etc).
#   - scripts/deploy.sh orchestrates pull + migrate + up + healthcheck
#     against any target. One command, same shape everywhere.
#   - .env.production.example documents the secret shape.
#   - docs/deployment/overview.md records the decision and operating
#     procedure.
#
# Nothing is deleted. The k8s/ manifests and scripts/pf.sh /
# push-fixes-v7.sh / push-fixes-v8.sh stay in-tree for reference.
#
# Run from the repo root on your Mac:
#     bash scripts/push-fixes-v9.sh
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
    docker-compose.prod.yml \
    scripts/deploy.sh \
    scripts/push-fixes-v9.sh \
    .env.production.example \
    docs/deployment/overview.md
do
    if [ ! -e "$f" ]; then
        echo "    MISSING: $f  <-- ABORT"
        exit 1
    fi
    echo "    $f"
done
echo

read -p "Commit + push v9 (docker-compose + GHCR, K8s retired)? [y/N] " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Aborted. No changes made."
    exit 1
fi

chmod +x scripts/deploy.sh scripts/push-fixes-v9.sh

git add \
    .github/workflows/deploy.yml \
    docker-compose.prod.yml \
    scripts/deploy.sh \
    scripts/push-fixes-v9.sh \
    .env.production.example \
    docs/deployment/overview.md

git commit -m "chore(deploy): retire K8s path, adopt docker-compose + GHCR

Every CI failure we chased on the self-hosted macOS runner + Docker
Desktop Kubernetes path (v6 QEMU build time, v7 missing GNU timeout,
v8 flaky NodePort->localhost binding) was an environment quirk, not
an application bug. Docker Desktop K8s is a development sandbox, not
a production target, and this project has no production traffic yet
to justify the operational complexity.

New shape:

  Pipeline  Test -> Build -> Push (GHCR). No deploy job.
            Image lives at ghcr.io/sherzot/trustflowcrm with tags
            :latest, :main, :sha-<short>. Auth via GITHUB_TOKEN —
            the workflow declares permissions: packages: write so no
            extra secrets are required.

  Local     docker compose up -d --build (unchanged). localhost:18080.

  Prod      docker-compose.prod.yml + scripts/deploy.sh on any Linux
            host. Pulls from GHCR, brings up db+redis, runs migrations
            in a one-shot container, rolls app forward, waits for the
            PHP-based healthcheck against /up. Same shape on AWS EC2,
            DigitalOcean, Hetzner, Railway, Fly.io VM.

  Secrets   .env.production.example documents the expected env shape.
            .env.production itself stays out of git.

  Docs      docs/deployment/overview.md records the decision, the new
            operating procedure, and how to put TLS in front with
            Caddy/nginx/Traefik.

Nothing is deleted. The k8s/ manifests, scripts/pf.sh, and the old
push-fixes-v7/v8 helpers stay in-tree for reference if a real K8s
target (EKS/GKE/DOKS) appears later."

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
echo "  1. Watch the Actions run go green:"
echo "       https://github.com/sherzot/TrustFlowCRM/actions"
echo "     Expected: Test + Build both green in ~4-6 minutes total."
echo "  2. Verify the image is published:"
echo "       https://github.com/sherzot/TrustFlowCRM/pkgs/container/trustflowcrm"
echo "  3. (Optional) Make the image public so future deploy hosts"
echo "     don't need a GHCR login:"
echo "       Repo -> Packages -> trustflowcrm -> Settings -> Visibility -> Public"
echo "  4. When you're ready to deploy to a cloud VM / VPS:"
echo "       git clone + cp .env.production.example .env.production"
echo "       edit .env.production"
echo "       bash scripts/deploy.sh"
