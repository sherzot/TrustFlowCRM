#!/usr/bin/env bash
# ----------------------------------------------------------------------------
# TrustFlow CRM — full rebuild & reseed
# Runs on the host machine (macOS or Linux), not inside the container.
# ----------------------------------------------------------------------------
set -euo pipefail

echo "==> Stopping existing stack (keeping volumes)…"
docker compose down --remove-orphans

echo "==> Building app image without cache so RoleSeeder / policies / theme are picked up…"
docker compose build --no-cache app

echo "==> Bringing stack up…"
docker compose up -d --force-recreate

echo "==> Waiting for MySQL to be ready…"
for i in {1..30}; do
    if docker compose exec -T db mysqladmin ping -h 127.0.0.1 -uroot -proot --silent 2>/dev/null; then
        echo "    DB is ready."
        break
    fi
    sleep 2
done

echo "==> Running migrate:fresh --seed inside the app container…"
docker compose exec -T -e HOME=/tmp app php artisan migrate:fresh --seed --force

echo "==> Verifying Super Admin account…"
docker compose exec -T -e HOME=/tmp app php artisan tinker --execute='
$u = App\Models\User::where("email","admin@trustflow.com")->first();
echo "user: " . ($u ? $u->email : "MISSING") . PHP_EOL;
echo "tenant_id: " . var_export($u?->tenant_id, true) . PHP_EOL;
echo "role: " . ($u?->hasRole("super_admin") ? "super_admin OK" : "MISSING ROLE") . PHP_EOL;
echo "perm deals.view: " . ($u?->can("deals.view") ? "yes" : "no") . PHP_EOL;
'

echo
echo "==> DONE."
echo "    Open http://localhost:18080/admin"
echo "    Login:   admin@trustflow.com / password"
