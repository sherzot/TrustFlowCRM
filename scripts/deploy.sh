#!/usr/bin/env bash
# ----------------------------------------------------------------------------
# TrustFlow CRM — production deploy helper
#
# Runs on any target host (VPS / cloud VM / even a dev Mac) that has:
#   - Docker + Docker Compose plugin installed
#   - a clone of the repo
#   - a filled-in .env.production
#
# It pulls the image from GHCR, starts db + redis, runs migrations in a
# one-shot container, then starts / upgrades the app. Safe to run
# repeatedly (idempotent upgrade).
#
# Usage:
#   bash scripts/deploy.sh                       # :latest
#   IMAGE_TAG=sha-abc1234 bash scripts/deploy.sh # pinned build
#
# First-time on a host (once):
#   git clone https://github.com/sherzot/TrustFlowCRM.git
#   cd TrustFlowCRM
#   cp .env.production.example .env.production
#   # edit .env.production (APP_KEY, DB_PASSWORD, MYSQL_*, OPENAI_API_KEY, …)
#   # if the GHCR image is private:
#   #   echo "$GHCR_TOKEN" | docker login ghcr.io -u sherzot --password-stdin
#   bash scripts/deploy.sh
# ----------------------------------------------------------------------------
set -euo pipefail

IMAGE_TAG="${IMAGE_TAG:-latest}"
COMPOSE_FILE="docker-compose.prod.yml"
export IMAGE_TAG

cd "$(dirname "$0")/.."

echo "==> Working dir: $(pwd)"
echo "==> Image tag:   ${IMAGE_TAG}"
echo "==> Compose:     ${COMPOSE_FILE}"
echo

if [ ! -f "${COMPOSE_FILE}" ]; then
    echo "ERROR: ${COMPOSE_FILE} not found."
    exit 1
fi

if [ ! -f .env.production ]; then
    echo "ERROR: .env.production not found."
    echo "       cp .env.production.example .env.production  and fill it in."
    exit 1
fi

# Sanity: docker + compose reachable?
if ! command -v docker >/dev/null 2>&1; then
    echo "ERROR: docker is not installed."
    exit 1
fi
if ! docker compose version >/dev/null 2>&1; then
    echo "ERROR: docker compose plugin is not available."
    exit 1
fi

echo "==> [1/5] Pulling images"
docker compose -f "${COMPOSE_FILE}" pull

echo
echo "==> [2/5] Starting db + redis"
docker compose -f "${COMPOSE_FILE}" up -d db redis

echo
echo "==> [3/5] Waiting for db to be healthy"
for i in $(seq 1 30); do
    STATUS=$(docker inspect --format='{{.State.Health.Status}}' trustflow-db 2>/dev/null || echo "starting")
    if [ "${STATUS}" = "healthy" ]; then
        echo "    db: healthy"
        break
    fi
    echo "    db: ${STATUS} (${i}/30)"
    sleep 3
done

echo
echo "==> [4/5] Running migrations (one-shot container)"
docker compose -f "${COMPOSE_FILE}" run --rm app \
    php artisan migrate --force

echo
echo "==> [5/5] Starting / upgrading app"
docker compose -f "${COMPOSE_FILE}" up -d app

echo
echo "==> Waiting for app to be healthy"
OK=0
for i in $(seq 1 40); do
    STATUS=$(docker inspect --format='{{.State.Health.Status}}' trustflow-app 2>/dev/null || echo "starting")
    if [ "${STATUS}" = "healthy" ]; then
        echo "    app: healthy"
        OK=1
        break
    fi
    echo "    app: ${STATUS} (${i}/40)"
    sleep 3
done

echo
echo "==> Final state:"
docker compose -f "${COMPOSE_FILE}" ps

if [ "${OK}" -ne 1 ]; then
    echo
    echo "WARNING: app did not report 'healthy' within the wait window."
    echo "         Recent app logs:"
    docker compose -f "${COMPOSE_FILE}" logs --tail=80 app || true
    exit 1
fi

APP_PORT="${APP_PORT:-8080}"
echo
echo "==> DONE"
echo "    App:     http://$(hostname -I 2>/dev/null | awk '{print $1}'):${APP_PORT}   (or behind your reverse proxy)"
echo "    Admin:   /admin"
echo "    Health:  /up"
