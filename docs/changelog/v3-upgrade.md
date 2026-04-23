# TrustFlow CRM v3.0 — Upgrade CHANGELOG (UZ / EN / JA)

Complementary to the 40+ page audit (`TrustFlowCRM_v3_Audit.docx`). All code changes have been applied **directly** to the local working copy at `/Users/sher_developer/Documents/GitHub/Projects/TrustFlowCRM`. A portable unified diff is also provided as `trustflow-crm-v3-upgrade.patch`.

---

## 1. Summary / Qisqacha / サマリー

| | UZ | EN | JA |
|---|---|---|---|
| **Multi-tenant izolyatsiya** | Global `TenantScope` + `BelongsToTenant` trait barcha tenant-bound modellarga qo'llandi. | Global `TenantScope` + `BelongsToTenant` trait applied to every tenant-bound model. | グローバル `TenantScope` と `BelongsToTenant` トレイトをすべてのテナント所有モデルに適用。 |
| **Middleware** | `EnsureTenantContext` har bir web/admin so'rovda Tenantni DI-ga bog'laydi. | `EnsureTenantContext` binds the active Tenant into the container on every web/admin request. | `EnsureTenantContext` が Web/管理リクエストごとにテナントを DI に束縛。 |
| **Authorization** | 8 ta resurs uchun Policy, Super Admin bypass, same-tenant check. | Policies for 8 resources with Super Admin bypass and same-tenant check. | 8 リソースの Policy、Super Admin バイパス、同一テナント検証を実装。 |
| **AI qatlami v2** | `app/Services/AI/*` — retry, cost logging, uz/en/ja promptlar, Redis cache. | `app/Services/AI/*` — retry, cost logging, uz/en/ja prompts, Redis cache. | `app/Services/AI/*` — リトライ、コストログ、uz/en/ja プロンプト、Redis キャッシュ。 |
| **DevOps** | Multi-stage Dockerfile, supervisord, OPcache+JIT, healthcheck, Mailpit/Adminer/Reverb. | Multi-stage Dockerfile with supervisord, OPcache+JIT, healthcheck, and Mailpit/Adminer/Reverb services. | マルチステージ Dockerfile、supervisord、OPcache+JIT、ヘルスチェック、Mailpit/Adminer/Reverb を整備。 |
| **CI/CD** | GitHub Actions (Pint + PHPStan + PHPUnit + Docker) va mahalliy Jenkinsfile. | GitHub Actions (Pint + PHPStan + PHPUnit + Docker) and local Jenkinsfile. | GitHub Actions（Pint + PHPStan + PHPUnit + Docker）とローカル Jenkinsfile を追加。 |
| **Kubernetes** | `k8s/` — namespace, configmap, secret sample, deployment, service, ingress, HPA. | `k8s/` — namespace, configmap, secret sample, deployment, service, ingress, HPA. | `k8s/` — namespace, configmap, secret サンプル, deployment, service, ingress, HPA を整備。 |
| **Testing** | `tests/Feature/TenantIsolationTest.php`, `PolicyTest.php`, `Unit/AIServiceTest.php`. | `tests/Feature/TenantIsolationTest.php`, `PolicyTest.php`, `Unit/AIServiceTest.php`. | `tests/Feature/TenantIsolationTest.php`, `PolicyTest.php`, `Unit/AIServiceTest.php` を追加。 |

---

## 2. New files

**Security & multi-tenancy**
- `app/Support/Scopes/TenantScope.php`
- `app/Support/Concerns/BelongsToTenant.php`
- `app/Http/Middleware/EnsureTenantContext.php`
- `app/Policies/BasePolicy.php`
- `app/Policies/{Account,Contact,Lead,Deal,Project,Task,Invoice,Contract}Policy.php`
- `app/Providers/AuthServiceProvider.php`

**AI layer v2**
- `app/Services/AI/PromptTemplates.php` — multi-locale (uz/en/ja) prompts
- `app/Services/AI/OpenAIClient.php` — HTTP client with retry + telemetry
- `app/Services/AI/AiCallLogger.php` — persists to `ai_calls`, cost calc
- `app/Services/AI/AIService.php` — high-level, tenant-aware, Redis-cached facade
- `config/ai.php` — pricing table + per-feature rate limits
- `database/migrations/2026_04_23_100000_create_ai_calls_table.php`

**DevOps**
- `docker/php/php.ini` — OPcache + JIT
- `docker/php/www.conf` — PHP-FPM pool
- `docker/supervisord.conf` — nginx + php-fpm + horizon + scheduler
- `Jenkinsfile`
- `.github/workflows/ci.yml` — Pint + PHPStan + PHPUnit + Docker build
- `k8s/namespace.yaml`, `configmap.yaml`, `secret.yaml.example`, `deployment.yaml`, `service.yaml`, `ingress.yaml`, `hpa.yaml`

**Testing & tooling**
- `phpstan.neon` (Larastan level 6)
- `pint.json`
- `tests/Feature/TenantIsolationTest.php`
- `tests/Feature/PolicyTest.php`
- `tests/Unit/AIServiceTest.php`

## 3. Replaced / modified files

- `Dockerfile` — multi-stage build (composer → node → runtime) with OPcache, non-root, healthcheck
- `docker-compose.yml` — adds Mailpit, Adminer, Reverb (profile-gated); MySQL healthcheck
- `docker/nginx/default.conf` — security headers, gzip, long-cache for `/build/*`, restricted FPM status
- `docker/mysql/my.cnf` — InnoDB tuning, slow-query log, strict SQL mode
- `.env.example` — Redis as default cache/session/queue; Reverb vars; OpenAI/AI config keys
- `config/services.php` — OpenAI: `base_url`, `model`, `timeout`, `max_retries`
- `bootstrap/app.php` — registers `AuthServiceProvider`, `tenant` middleware alias, appends `EnsureTenantContext` + `SetLocale`
- `app/Models/User.php` — tightened `canAccessPanel` (Super Admin + tenant + role check)
- `app/Models/{Lead,Deal,Account,Contact,Project,Task,Invoice,Contract,Activity,TimeEntry}.php` — added `BelongsToTenant`

## 4. How to apply the patch file (alternative workflow)

If you want to re-apply these changes to a **fresh clone** (e.g. on another machine or CI):

```bash
git clone https://github.com/sherzot/TrustFlowCRM.git
cd TrustFlowCRM
git apply --whitespace=nowarn /path/to/trustflow-crm-v3-upgrade.patch
```

The patch was generated from upstream `main` at commit `0212e10` (`fix: Add safety check to permission tables migration`).

## 5. Post-install checklist

```bash
# 1. Install deps.
composer install
npm install && npm run build

# 2. Environment.
cp .env.example .env
php artisan key:generate

# 3. Redis + MySQL up via docker compose.
docker compose up -d --build

# 4. Migrate + seed (includes the new ai_calls table).
docker compose exec app php artisan migrate --seed

# 5. Run the quality gates locally (same as CI).
vendor/bin/pint --test
vendor/bin/phpstan analyse --memory-limit=1G
vendor/bin/phpunit
```

## 6. Follow-ups not in this upgrade

These are documented in the audit (Chapter 5 "Recommendations") but were **not** auto-applied to avoid speculative refactors without your sign-off:

1. Migrate Filament Resources to use the new policies (`$resource->authorize('view')`, etc.) — needs a page-by-page review.
2. Replace the legacy `App\Services\AIService` call sites with `App\Services\AI\AIService`.
3. Introduce DTOs + Repositories for `Deal`, `Lead`, `Project` (recommended in the audit §3.2).
4. Add observability (OpenTelemetry exporter for `ai_calls` latency, PHP-FPM status scrape).
5. Harden secrets: move from `.env` to a secrets manager (Vault / AWS SM) when AWS phase begins.

---

*Generated 2026-04-23 as part of the TrustFlow CRM v3.0 Enterprise Upgrade. — UZ/EN/JA triple-language deliverable.*
