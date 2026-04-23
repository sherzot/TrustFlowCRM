# TrustFlow CRM

🇬🇧 **English** · [🇯🇵 日本語](README.ja.md) · [🇺🇿 O'zbekcha](README.uz.md)

> A modern, multi-tenant, RBAC-driven CRM for sales, delivery, and finance teams — built on **Laravel 11 + Filament 3.2** with the **TrustFlow Indigo** design language.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)
![Filament](https://img.shields.io/badge/Filament-3.2-FFB800?style=flat)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php)
![Docker](https://img.shields.io/badge/Docker-ready-2496ED?style=flat&logo=docker)
![License](https://img.shields.io/badge/license-MIT-green)

---

## What is TrustFlow CRM?

**TrustFlow CRM** is a multi-tenant CRM platform for B2B agencies and service
companies. It unifies the **sales pipeline** (leads → deals → contracts), the
**delivery pipeline** (projects → tasks), and the **finance pipeline**
(invoices → payments → reporting) into a single, role-isolated workspace.

Every tenant is fully isolated at the data layer. Every action is gated by an
explicit, dot-notation permission. And every screen — from the dashboard KPIs
to the Kanban boards — is styled in the **TrustFlow Indigo** design language,
tuned for the trust-critical tone B2B work demands.

---

## Key Features

### Multi-tenancy, baked in
Every tenant-scoped model uses the `BelongsToTenant` trait and a `TenantScope`
global scope. The `EnsureTenantContext` middleware and `BasePolicy::sameTenant()`
enforce isolation on every request and every policy check. `super_admin`
(`tenant_id = null`) is explicitly allowed through for platform operations.

### 7-role RBAC with workflow permissions
A canonical 7-role matrix (`super_admin`, `admin`, `manager`, `sales`,
`delivery`, `finance`, `viewer`) with dot-notation permissions
(`deals.view`, `invoices.approve`, `leads.convert`, …). Fully documented as
the **single source of truth** in [`docs/roles/role-matrix.md`](docs/roles/role-matrix.md).

### Sales, delivery, and finance, in one panel
- **Sales** — Accounts, Contacts, Leads, Deals, Contracts, Kanban board.
- **Delivery** — Projects, Tasks, progress tracking, time entries.
- **Finance** — Invoices, multi-currency, approvals, paid/unpaid workflows.
- **Analytics** — `TrustFlowKpiWidget` (Revenue MTD, Pipeline, Win Rate,
  Open Invoices), Sales Funnel, Profit Chart, OKR dashboard.

### AI service layer
An `AIService` facade, an `OpenAIClient` with timeout + retry, versioned
`PromptTemplates`, and an `AiCallLogger` that persists every call to the
`ai_calls` table for cost attribution. Drop-in ready for lead scoring,
deal prediction, and email drafting.

### TrustFlow Indigo design language
Indigo primary, Slate gray, Emerald success, Amber warning, Rose danger, Sky
info. Inter font with tabular nums. Refined sidebar, topbar, and tables.
Loaded via a Filament render hook — **no Vite build required**.

### Multilingual
UI in **English / 日本語 / O'zbekcha / Русский**. Canonical docs in English
with trilingual role-matrix copies under
[`docs/i18n/`](docs/i18n/).

### Operations-ready
Docker Compose stack (nginx + php-fpm + MySQL + Redis + Horizon + scheduler),
GitHub Actions CI (Pint + PHPStan level 6 + tests), a mirror `Jenkinsfile`
for on-prem, and a K8s reference manifest set under [`k8s/`](k8s/).

---

## Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                      Filament Admin Panel                    │
│   Sales · Delivery · Finance · Analytics · System            │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│  EnsureTenantContext ─►  BasePolicy (before + sameTenant)    │
│            ▼                        ▼                        │
│   TenantScope (global)       dot-notation permissions        │
└─────────────────────────────────────────────────────────────┘
                              │
          ┌───────────────────┼───────────────────┐
          ▼                   ▼                   ▼
   ┌────────────┐      ┌────────────┐      ┌────────────┐
   │   MySQL    │      │   Redis    │      │  AI layer  │
   │  (tenant-  │      │ (cache +   │      │ OpenAI +   │
   │  scoped)   │      │  queue)    │      │  call log  │
   └────────────┘      └────────────┘      └────────────┘
```

High-level details: [`docs/architecture/overview.md`](docs/architecture/overview.md).

---

## Tech Stack

| Layer | Technology |
| --- | --- |
| Backend | Laravel 11 (PHP 8.2+) |
| Admin UI | Filament 3.2 |
| Database | MySQL 8 |
| Cache / Queue | Redis 7 + Horizon |
| RBAC | spatie/laravel-permission |
| AI | OpenAI (via `App\Services\AI\OpenAIClient`) |
| Testing | Pest / PHPUnit |
| Static analysis | Larastan (level 6) |
| Formatter | Laravel Pint (strict types) |
| Container | Docker + Docker Compose |
| Orchestration | Kubernetes (reference manifests in `k8s/`) |
| CI/CD | GitHub Actions + Jenkins |

---

## Quick Start (Docker)

```bash
# 1. Clone
git clone https://github.com/sherzot/TrustFlowCRM.git
cd TrustFlowCRM

# 2. Copy env
cp .env.example .env

# 3. Full rebuild + seed (Docker build + migrate:fresh --seed + verify)
./scripts/rebuild-and-seed.sh

# 4. Open
open http://localhost:18080
```

Default Super Admin: `admin@trustflow.com` / `password` ·
full seeded user table: [`docs/README.md#canonical-seed-users`](docs/README.md#canonical-seed-users-local--staging-only).

> Rotate all seeded credentials before any non-local deployment.

Prefer a manual setup? See [`docs/deployment/setup.md`](docs/deployment/setup.md).

---

## Roles at a glance

| Role | Scope | Core responsibility |
| --- | --- | --- |
| `super_admin` | Platform | Cross-tenant operator, bypasses every policy via `before()` |
| `admin` | Tenant | Full CRUD + user management + approvals inside a tenant |
| `manager` | Tenant | Sales/Ops lead — reviews & approves deals and invoices |
| `sales` | Tenant | Owns the lead → deal → contract funnel |
| `delivery` | Tenant | Owns projects and tasks post-contract |
| `finance` | Tenant | Invoice lifecycle, payments, financial reporting |
| `viewer` | Tenant | Read-only auditor / external stakeholder |

Full matrix with every permission and workflow rule:
[`docs/roles/role-matrix.md`](docs/roles/role-matrix.md).
Localized: [🇯🇵 JA](docs/i18n/ja/role-matrix.md) · [🇺🇿 UZ](docs/i18n/uz/role-matrix.md).

---

## Design language — TrustFlow Indigo

A refined, professional palette for trust-critical SaaS.

| Token | Color | Use |
| --- | --- | --- |
| `primary` | Indigo | Brand, primary CTAs, active sidebar items |
| `gray` | Slate | Neutral canvas, body text, borders |
| `success` | Emerald | Won deals, paid invoices |
| `warning` | Amber | At-risk, overdue |
| `danger` | Rose | Lost, failed |
| `info` | Sky | Informational banners |

Inspired by the clarity of Linear, the restraint of Attio, and the polish of
Notion. Theme CSS: [`public/css/trustflow-theme.css`](public/css/trustflow-theme.css) —
loaded via a Filament `STYLES_AFTER` render hook in
[`AdminPanelProvider`](app/Providers/Filament/AdminPanelProvider.php). **No Vite build step required.**

---

## Documentation

All engineering, ops, and onboarding material lives under
[`docs/`](docs/README.md):

```
docs/
├── README.md                  Documentation home
├── architecture/overview.md   System architecture & boundaries
├── roles/
│   ├── role-matrix.md         Canonical 7-role RBAC matrix
│   └── legacy-rbac.md         Historical permission model
├── deployment/
│   ├── setup.md               Local dev bootstrap
│   ├── docker.md              Docker stack internals
│   └── deployment.md          Staging / production runbook
├── changelog/
│   ├── v3-upgrade.md          v2 → v3 upgrade notes
│   └── v3-upgrade.patch       Diff capture
└── i18n/
    ├── ja/role-matrix.md      役割マトリクス (日本語)
    └── uz/role-matrix.md      Rol matritsasi (o'zbekcha)
```

Release history: [`CHANGELOG.md`](CHANGELOG.md) (Keep a Changelog 1.1.0 · SemVer 2.0.0).

---

## Operational scripts

| Script | Purpose |
| --- | --- |
| [`scripts/rebuild-and-seed.sh`](scripts/rebuild-and-seed.sh) | Full Docker rebuild + `migrate:fresh --seed` + Super Admin verification. Run after any RBAC or theme change. |
| [`scripts/publish-to-github.sh`](scripts/publish-to-github.sh) | Publish a prepared git-bundle of commits to `origin/main`. Used when commits are prepared in a sandboxed session. |

---

## Contributing

1. Open an issue or discussion before large changes.
2. Follow the code standards: `composer pint` + `composer phpstan` must pass.
3. RBAC change → update [`docs/roles/role-matrix.md`](docs/roles/role-matrix.md),
   the `RoleSeeder`, and the i18n copies.
4. Schema change → write a migration, reseed, note breaking changes under
   [`docs/changelog/`](docs/changelog/) and add an entry to [`CHANGELOG.md`](CHANGELOG.md).
5. One conventional commit per logical change (`feat:`, `fix:`, `docs:`,
   `chore(devops):`, …).

---

## License

Released under the [MIT License](LICENSE).

---

## Links

- **Repo:** https://github.com/sherzot/TrustFlowCRM
- **Docs home:** [`docs/README.md`](docs/README.md)
- **Changelog:** [`CHANGELOG.md`](CHANGELOG.md)
- **Maintainer:** [@sherzot](https://github.com/sherzot)
