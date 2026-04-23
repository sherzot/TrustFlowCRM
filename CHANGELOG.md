# Changelog

All notable changes to **TrustFlow CRM** are documented in this file.

The format is based on [Keep a Changelog 1.1.0](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning 2.0.0](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

_Nothing yet._

---

## [3.1.0] — 2026-04-24

Major RBAC refactor, UI redesign, documentation overhaul, and devops
hardening. Net: +6 focused commits, +81 files changed.

### Added

- **Canonical 7-role RBAC matrix** (`docs/roles/role-matrix.md`) — the
  single source of truth for permissions. Roles: `super_admin`, `admin`,
  `manager`, `sales`, `delivery`, `finance`, `viewer`. All names
  `snake_case`, `guard_name = web`.
- **`viewer` role** — read-only auditor / external stakeholder scope.
  Seeded as `viewer@test.com`.
- **Workflow permissions** — `leads.convert`, `deals.win`, `deals.lose`,
  `deals.approve`, `contracts.sign`, `invoices.send`, `invoices.markPaid`,
  `invoices.approve`, `reports.export`, `users.assignRole`.
- **`TrustFlowKpiWidget`** — full-width dashboard widget with 4 KPIs:
  Revenue MTD, Pipeline Value, Win Rate (30d, color-coded), Open Invoices.
  Handles `super_admin` (tenant_id=null) correctly by aggregating across
  all tenants.
- **`TrustFlow Indigo` design language** — Indigo primary, Slate gray,
  Emerald success, Amber warning, Rose danger, Sky info. Inter font with
  tabular nums, soft shadows, refined sidebar + topbar + tables. CSS at
  `public/css/trustflow-theme.css`, no Vite build required.
- **AI service layer** — `app/Services/AI/`: `AIService` facade,
  `OpenAIClient` (timeout + retry), `PromptTemplates` (versioned), and
  `AiCallLogger` persisting calls to `ai_calls` for cost attribution.
- **`/docs` tree** — structured docs home with `architecture/`, `roles/`,
  `deployment/`, `changelog/`, and `i18n/`. New entry-point
  `docs/README.md`.
- **Trilingual role matrix** — `docs/roles/role-matrix.md` (canonical EN)
  plus `docs/i18n/ja/role-matrix.md` and `docs/i18n/uz/role-matrix.md`.
- **Base policy infrastructure** — `app/Policies/BasePolicy.php` with
  `before()` bypass for `super_admin` and `sameTenant()` guard.
- **Tenant scoping primitives** — `app/Support/Concerns/BelongsToTenant`
  trait and `app/Support/Scopes/TenantScope` global scope.
- **K8s reference manifests** — `k8s/` with namespace, configmap,
  secret template, deployment, service, ingress, HPA.
- **CI/CD** — `.github/workflows/ci.yml` (Pint + PHPStan + tests) and
  mirror `Jenkinsfile` for on-prem.
- **Code quality tooling** — `phpstan.neon` (larastan level 6) and
  `pint.json` (Laravel preset + strict types).
- **Ops scripts** — `scripts/rebuild-and-seed.sh` for full Docker rebuild
  and verified reseed.

### Changed

- **Permissions migrated to dot-notation** — `{resource}.{action}`
  (e.g. `deals.view`, `invoices.approve`) replaces the old space-form
  (`view deals`). 24 Filament Resources, Pages, and Controllers updated
  to match.
- **Navigation grouping** — Filament sidebar reorganized into 5 groups:
  Sales, Delivery, Finance, Analytics, System. Localized labels in
  `en/ja/uz/ru`.
- **`AdminPanelProvider`** — rewritten for TrustFlow Indigo branding:
  brand name, primary/gray/success/warning/danger/info color map, dark
  mode via `ThemeMode::System`, collapsible sidebar, global search,
  breadcrumbs, DB notifications.
- **Seeders** — `RoleSeeder` fully rewritten (idempotent
  `syncPermissions`, `forgetCachedPermissions()` at start+end).
  `UserSeeder` adds the viewer account.
- **Docs relocated** — `ARCHITECTURE.md` → `docs/architecture/overview.md`;
  `DEPLOYMENT.md` → `docs/deployment/deployment.md`;
  `DOCKER.md` → `docs/deployment/docker.md`;
  `SETUP.md` → `docs/deployment/setup.md`;
  `ROLE_BASED_ACCESS.md` → `docs/roles/legacy-rbac.md`.
- **`.gitignore`** — extended to exclude `.DS_Store`, Laravel runtime
  caches (`storage/framework/{cache,sessions,views}/*`), logs, and
  `bootstrap/cache/*`.

### Fixed

- **403 USER HAS NO TENANT ASSIGNED on dashboard widget.** Root cause:
  `EnsureTenantContext.php:36` checked `hasRole('Super Admin')`
  (title-case) while `RoleSeeder` creates `super_admin` (snake_case).
  Because Livewire widget updates hit middleware on every poll, the
  dashboard widget 403'd even as list pages rendered normally.
  Now checks `'super_admin'` (snake_case).
- **`ContractResource::shouldRegisterNavigation`** — typo returned
  `can('deals.view')` instead of `can('contracts.view')`.
- **Permission cache staleness after seed** — `RoleSeeder` now calls
  `PermissionRegistrar::forgetCachedPermissions()` both at the start
  (before syncing) and at the end, so fresh seeds don't read stale
  permissions from Redis.

### Security

- **Tenant isolation hardened** — every tenant-scoped model uses
  `BelongsToTenant` trait + `TenantScope` global scope. `BasePolicy`
  enforces `sameTenant()` on every method. `super_admin` (tenant_id =
  null) is explicitly allowed through `EnsureTenantContext` and the
  `before()` hook.

---

## [3.0.0] — 2025-12-30

Baseline release. Laravel 11 + Filament 3.2, multi-tenant scaffold,
initial RBAC (6 roles, space-form permissions), sales/delivery/finance
resources, Docker stack. See `docs/changelog/v3-upgrade.md` for the
original v2 → v3 upgrade notes.

[Unreleased]: https://github.com/sherzot/TrustFlowCRM/compare/v3.1.0...HEAD
[3.1.0]: https://github.com/sherzot/TrustFlowCRM/compare/v3.0.0...v3.1.0
[3.0.0]: https://github.com/sherzot/TrustFlowCRM/releases/tag/v3.0.0
