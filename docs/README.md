# TrustFlow CRM — Documentation

Welcome to the TrustFlow CRM docs tree. This is the single entry point for all
engineering, operations, and onboarding material for the platform.

TrustFlow CRM is a multi-tenant, RBAC-driven CRM built on **Laravel 11 +
Filament 3.2**, with tenant isolation enforced at the model, middleware, and
policy layers. The design language is **TrustFlow Indigo** (Indigo / Slate /
Emerald), inspired by Linear, Attio, and Notion.

---

## Map of the docs

```
docs/
├── README.md                  ← you are here
├── architecture/
│   └── overview.md            High-level architecture, boundaries, data flow
├── roles/
│   ├── role-matrix.md         Canonical RBAC matrix (source of truth)
│   └── legacy-rbac.md         Historical permission model, kept for reference
├── deployment/
│   ├── setup.md               Local dev environment bootstrap
│   ├── docker.md              Docker Compose stack & image internals
│   └── deployment.md          Staging / production deployment runbook
├── changelog/
│   ├── v3-upgrade.md          Filament v3 upgrade notes & migration guide
│   └── v3-upgrade.patch       Diff capture from the v3 upgrade
├── i18n/
│   ├── ja/role-matrix.md      役割マトリクス (日本語)
│   └── uz/role-matrix.md      Rol matritsasi (o'zbekcha)
└── api/                       (reserved for REST / webhook docs)
```

---

## Start here

**New to the project?** Read in this order:

1. [`architecture/overview.md`](architecture/overview.md) — what the system is
   and how the pieces fit together.
2. [`roles/role-matrix.md`](roles/role-matrix.md) — who can do what. This is the
   RBAC contract; code must match it.
3. [`deployment/setup.md`](deployment/setup.md) — get the app running locally.
4. [`deployment/docker.md`](deployment/docker.md) — how the container stack is
   put together.

**Shipping changes?** Before you merge:

- RBAC change → update [`roles/role-matrix.md`](roles/role-matrix.md) and run
  `scripts/rebuild-and-seed.sh`.
- Schema change → write a migration, reseed, and note breaking changes in a new
  file under `changelog/`.
- Deployment change → update [`deployment/deployment.md`](deployment/deployment.md).

---

## RBAC at a glance

| Role | Scope | Core responsibility |
| --- | --- | --- |
| `super_admin` | Platform | Cross-tenant operator, bypasses every policy via `before()` |
| `admin` | Tenant | Full CRUD + user management + approvals inside a tenant |
| `manager` | Tenant | Sales/Ops lead — reviews & approves deals and invoices |
| `sales` | Tenant | Owns the lead → deal → contract funnel |
| `delivery` | Tenant | Owns projects and tasks post-contract |
| `finance` | Tenant | Invoice lifecycle, payments, financial reporting |
| `viewer` | Tenant | Read-only auditor / external stakeholder |

Full permission table and workflow rules: [`roles/role-matrix.md`](roles/role-matrix.md).

Localized versions:

- 🇯🇵 Japanese — [`i18n/ja/role-matrix.md`](i18n/ja/role-matrix.md)
- 🇺🇿 Uzbek — [`i18n/uz/role-matrix.md`](i18n/uz/role-matrix.md)

---

## Design language

**TrustFlow Indigo.** A refined, professional palette for trust-critical SaaS.

| Token | Color | Use |
| --- | --- | --- |
| `primary` | Indigo | Brand, primary CTAs, active sidebar items |
| `gray` | Slate | Neutral canvas, body text, borders |
| `success` | Emerald | Won deals, paid invoices |
| `warning` | Amber | At-risk, overdue |
| `danger` | Rose | Lost, failed |
| `info` | Sky | Informational banners |

Theme CSS lives at [`public/css/trustflow-theme.css`](../public/css/trustflow-theme.css)
and is loaded via a Filament `STYLES_AFTER` render hook in
[`app/Providers/Filament/AdminPanelProvider.php`](../app/Providers/Filament/AdminPanelProvider.php).
No Vite build step is required.

---

## Operational scripts

| Script | Purpose |
| --- | --- |
| [`scripts/rebuild-and-seed.sh`](../scripts/rebuild-and-seed.sh) | Full Docker rebuild + `migrate:fresh --seed` + Super Admin verification. Run this after any RBAC or theme change. |

---

## Conventions

- **Role names:** always `snake_case`, `guard_name = web`. Must match exactly
  across `RoleSeeder`, `User::canAccessPanel()`, `BasePolicy::before()`, and
  `EnsureTenantContext`.
- **Permissions:** dot-notation `{resource}.{action}` (e.g. `deals.approve`).
  This aligns with `$user->can($this->resource.'.view')` in `BasePolicy`.
- **Tenant scope:** every tenant-scoped model uses the `BelongsToTenant` trait
  and `TenantScope` global scope. Super Admin (`tenant_id = null`) is allowed
  through by `EnsureTenantContext` and `BasePolicy::sameTenant()`.
- **Documentation:** the role matrix is a contract. Any RBAC change must update
  both the seeder and `roles/role-matrix.md` (plus the i18n versions if the
  matrix itself changes).

---

## Canonical seed users (local / staging only)

| Email | Role | Password | tenant_id |
| --- | --- | --- | --- |
| admin@trustflow.com | super_admin | `password` | `null` |
| admin@test.com | admin | `admin123` | 1 |
| manager@test.com | manager | `manager123` | 1 |
| sales@test.com | sales | `sales123` | 1 |
| delivery@test.com | delivery | `delivery123` | 1 |
| finance@test.com | finance | `finance123` | 1 |
| viewer@test.com | viewer | `viewer123` | 1 |

**Rotate these before any non-local deployment.** See
[`database/seeders/UserSeeder.php`](../database/seeders/UserSeeder.php).
