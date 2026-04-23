# TrustFlow CRM

[🇬🇧 English](README.md) · [🇯🇵 日本語](README.ja.md) · 🇺🇿 **O'zbekcha**

> Sales, delivery va finance jamoalari uchun zamonaviy, ko'p-ijarachili (multi-tenant), RBAC-asosli CRM — **Laravel 11 + Filament 3.2** va **TrustFlow Indigo** dizayn tiliga qurilgan.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)
![Filament](https://img.shields.io/badge/Filament-3.2-FFB800?style=flat)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php)
![Docker](https://img.shields.io/badge/Docker-ready-2496ED?style=flat&logo=docker)
![License](https://img.shields.io/badge/license-MIT-green)

---

## TrustFlow CRM nima?

**TrustFlow CRM** — B2B agentliklar va xizmat kompaniyalari uchun mo'ljallangan
ko'p-ijarachili CRM platformasi. U **sales pipeline** (leadlar → dealiar →
shartnomalar), **delivery pipeline** (loyihalar → vazifalar) va **finance
pipeline** (invoyslar → to'lovlar → hisobotlar) jarayonlarini bitta,
rollar bo'yicha izolyatsiya qilingan ish maydonida birlashtiradi.

Har bir ijarachi (tenant) ma'lumotlar qatlamida to'liq izolyatsiya qilingan.
Har bir harakat aniq, nuqta-yozuvli ruxsat bilan boshqariladi. Har bir ekran
— dashboard KPI'laridan tortib Kanban taxtalarigacha — B2B ishi talab qiladigan
ishonchli tonga moslashtirilgan **TrustFlow Indigo** dizayn tilida jilvalanadi.

---

## Asosiy imkoniyatlar

### Multi-tenant — dizayn darajasida
Har bir tenant-scoped modelda `BelongsToTenant` traiti va `TenantScope` global
scope'i ishlatiladi. `EnsureTenantContext` middleware va `BasePolicy::sameTenant()`
har bir so'rov va har bir policy tekshiruvida izolyatsiyani ta'minlaydi.
`super_admin` (`tenant_id = null`) platforma amaliyotlari uchun alohida
ruxsat etilgan.

### 7 rolli RBAC + workflow ruxsatlari
Kanonik 7 rolli matritsa (`super_admin`, `admin`, `manager`, `sales`,
`delivery`, `finance`, `viewer`) va nuqta-yozuvli ruxsatlar (`deals.view`,
`invoices.approve`, `leads.convert`…). **Haqiqatning yagona manbai** sifatida
[`docs/roles/role-matrix.md`](docs/roles/role-matrix.md) faylida hujjatlashtirilgan.

### Sales, delivery va finance — bitta panelda
- **Sales** — Akkauntlar, kontaktlar, leadlar, deallar, shartnomalar, Kanban taxta.
- **Delivery** — Loyihalar, vazifalar, progress tracking, vaqt yozuvlari.
- **Finance** — Invoyslar, ko'p valyuta, tasdiqlashlar, to'lov workflow'lari.
- **Analytics** — `TrustFlowKpiWidget` (Revenue MTD, Pipeline, Win Rate,
  Open Invoices), Sales Funnel, Profit Chart, OKR dashboard.

### AI service qatlami
`AIService` facade, timeout + retry bilan `OpenAIClient`, versiyalangan
`PromptTemplates` va har bir chaqiruvni `ai_calls` jadvaliga saqlab narx
hisobini yurgizadigan `AiCallLogger`. Lead scoring, deal prediction va
email drafting uchun darhol tayyor.

### TrustFlow Indigo dizayn tili
Asosiy rang — indigo, neytral — slate, muvaffaqiyat — emerald, ogohlantirish
— amber, xavf — rose, ma'lumot — sky. Tabular raqamli Inter shrifti.
Jilvalangan sidebar, topbar va jadvallar. Filament render hook orqali
yuklanadi — **Vite build kerak emas**.

### Ko'p tilli
UI **English / 日本語 / O'zbekcha / Русский** tillarida. Hujjatlar kanonik
ingliz tilida, [`docs/i18n/`](docs/i18n/) ostida uch tilli role-matrix
nusxalari.

### Operatsiyaga tayyor
Docker Compose stack (nginx + php-fpm + MySQL + Redis + Horizon + scheduler),
GitHub Actions CI (Pint + PHPStan level 6 + testlar), on-prem uchun
`Jenkinsfile` ko'zgu va [`k8s/`](k8s/) ostidagi K8s reference manifestlari.

---

## Arxitektura

```
┌─────────────────────────────────────────────────────────────┐
│                   Filament Admin Paneli                      │
│   Sales · Delivery · Finance · Analytics · System            │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│  EnsureTenantContext ─►  BasePolicy (before + sameTenant)    │
│            ▼                        ▼                        │
│   TenantScope (global)       nuqta-yozuvli ruxsatlar          │
└─────────────────────────────────────────────────────────────┘
                              │
          ┌───────────────────┼───────────────────┐
          ▼                   ▼                   ▼
   ┌────────────┐      ┌────────────┐      ┌────────────┐
   │   MySQL    │      │   Redis    │      │  AI layer  │
   │ (tenant-   │      │ (cache +   │      │ OpenAI +   │
   │  scoped)   │      │  queue)    │      │  call log  │
   └────────────┘      └────────────┘      └────────────┘
```

Batafsil: [`docs/architecture/overview.md`](docs/architecture/overview.md).

---

## Texnologiya steki

| Qatlam | Texnologiya |
| --- | --- |
| Backend | Laravel 11 (PHP 8.2+) |
| Admin UI | Filament 3.2 |
| Ma'lumotlar bazasi | MySQL 8 |
| Cache / Queue | Redis 7 + Horizon |
| RBAC | spatie/laravel-permission |
| AI | OpenAI (`App\Services\AI\OpenAIClient` orqali) |
| Testing | Pest / PHPUnit |
| Statik tahlil | Larastan (level 6) |
| Formatter | Laravel Pint (strict types) |
| Konteyner | Docker + Docker Compose |
| Orkestratsiya | Kubernetes (`k8s/` da reference manifestlari) |
| CI/CD | GitHub Actions + Jenkins |

---

## Tez start (Docker)

```bash
# 1. Klonlash
git clone https://github.com/sherzot/TrustFlowCRM.git
cd TrustFlowCRM

# 2. Env faylini ko'chirish
cp .env.example .env

# 3. To'liq rebuild + seed (Docker build + migrate:fresh --seed + verify)
./scripts/rebuild-and-seed.sh

# 4. Ochish
open http://localhost:18080
```

Standart Super Admin: `admin@trustflow.com` / `password` ·
to'liq seed qilingan foydalanuvchilar jadvali:
[`docs/README.md#canonical-seed-users`](docs/README.md#canonical-seed-users-local--staging-only).

> Mahalliy bo'lmagan har qanday deployment oldidan barcha seed credentiallarni
> almashtiring.

Qo'lda sozlashni afzal ko'rasizmi? [`docs/deployment/setup.md`](docs/deployment/setup.md) ga qarang.

---

## Rollar qisqacha

| Rol | Scope | Asosiy mas'uliyat |
| --- | --- | --- |
| `super_admin` | Platforma | Tenantlararo operator, `before()` orqali har qanday policy'ni bypass qiladi |
| `admin` | Tenant | Tenant ichida to'liq CRUD + foydalanuvchi boshqaruvi + tasdiqlashlar |
| `manager` | Tenant | Sales/Ops yetakchisi — deallar va invoyslarni ko'rib chiqadi va tasdiqlaydi |
| `sales` | Tenant | Lead → deal → shartnoma funnelini boshqaradi |
| `delivery` | Tenant | Shartnomadan keyingi loyihalar va vazifalarni boshqaradi |
| `finance` | Tenant | Invoyslar hayotiy sikli, to'lovlar, moliyaviy hisobotlar |
| `viewer` | Tenant | Faqat o'qish rejimidagi auditor / tashqi stakeholder |

Har bir ruxsat va workflow qoidasi bilan to'liq matritsa:
[`docs/roles/role-matrix.md`](docs/roles/role-matrix.md).
Tarjimalari: [🇯🇵 JA](docs/i18n/ja/role-matrix.md) · [🇺🇿 UZ](docs/i18n/uz/role-matrix.md).

---

## Dizayn tili — TrustFlow Indigo

Ishonchga bog'liq SaaS uchun jilvalangan, professional palitra.

| Token | Rang | Qo'llanilishi |
| --- | --- | --- |
| `primary` | Indigo | Brend, asosiy CTA'lar, faol sidebar elementlari |
| `gray` | Slate | Neytral fon, matn, chegaralar |
| `success` | Emerald | Yutilgan deallar, to'langan invoyslar |
| `warning` | Amber | Riskli, muddati o'tgan |
| `danger` | Rose | Yo'qotilgan, muvaffaqiyatsiz |
| `info` | Sky | Ma'lumot bannerlari |

Linear'ning aniqligi, Attio'ning minimalizmi va Notion'ning silliqligidan
ilhomlangan. Theme CSS: [`public/css/trustflow-theme.css`](public/css/trustflow-theme.css) —
[`AdminPanelProvider`](app/Providers/Filament/AdminPanelProvider.php) da
Filament `STYLES_AFTER` render hook orqali yuklanadi. **Vite build kerak emas.**

---

## Hujjatlar

Barcha engineering, operatsiyalar va onboarding materiallari
[`docs/`](docs/README.md) ostida joylashgan:

```
docs/
├── README.md                  Hujjatlar bosh sahifasi
├── architecture/overview.md   Tizim arxitekturasi va chegaralari
├── roles/
│   ├── role-matrix.md         Kanonik 7 rolli RBAC matritsasi
│   └── legacy-rbac.md         Tarixiy ruxsat modeli
├── deployment/
│   ├── setup.md               Mahalliy dev bootstrap
│   ├── docker.md              Docker stack ichki tuzilishi
│   └── deployment.md          Staging / production runbook
├── changelog/
│   ├── v3-upgrade.md          v2 → v3 upgrade eslatmalari
│   └── v3-upgrade.patch       Diff capture
└── i18n/
    ├── ja/role-matrix.md      役割マトリクス (日本語)
    └── uz/role-matrix.md      Rol matritsasi (o'zbekcha)
```

Reliz tarixi: [`CHANGELOG.md`](CHANGELOG.md) (Keep a Changelog 1.1.0 · SemVer 2.0.0).

---

## Operatsion skriptlar

| Skript | Vazifasi |
| --- | --- |
| [`scripts/rebuild-and-seed.sh`](scripts/rebuild-and-seed.sh) | To'liq Docker rebuild + `migrate:fresh --seed` + Super Admin verify. RBAC yoki theme o'zgarishidan keyin ishga tushiring. |
| [`scripts/publish-to-github.sh`](scripts/publish-to-github.sh) | Oldindan tayyorlangan git-bundle commitlarini `origin/main` ga publish qilish. Sandboxli sessiyada tayyorlangan commitlar uchun. |

---

## Contributing

1. Katta o'zgarishlardan oldin issue yoki discussion oching.
2. Kod standartlari: `composer pint` + `composer phpstan` o'tishi shart.
3. RBAC o'zgarishi → [`docs/roles/role-matrix.md`](docs/roles/role-matrix.md),
   `RoleSeeder` va i18n nusxalarini yangilang.
4. Schema o'zgarishi → migration yozing, qayta seed qiling, breaking
   change'larni [`docs/changelog/`](docs/changelog/) da qayd eting va
   [`CHANGELOG.md`](CHANGELOG.md) ga yozuv qo'shing.
5. Har bir mantiqiy o'zgarish uchun bitta conventional commit (`feat:`,
   `fix:`, `docs:`, `chore(devops):`, …).

---

## Litsenziya

[MIT License](LICENSE) ostida chiqarilgan.

---

## Havolalar

- **Repo:** https://github.com/sherzot/TrustFlowCRM
- **Hujjatlar:** [`docs/README.md`](docs/README.md)
- **Changelog:** [`CHANGELOG.md`](CHANGELOG.md)
- **Maintainer:** [@sherzot](https://github.com/sherzot)
