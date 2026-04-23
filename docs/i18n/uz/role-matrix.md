# TrustFlow CRM — Rol Matritsasi

> **RBAC uchun yagona haqiqat manbasi.** Kodda `database/seeders/RoleSeeder.php` aniqlaydi,
> `app/Policies/BasePolicy.php` majburiy qiladi.

## Rollar tasnifi

| Rol           | Ko'lam       | Mas'uliyat                                                                     |
| ------------- | ------------ | ------------------------------------------------------------------------------ |
| `super_admin` | Platforma    | Platforma operatori, tenantlar kesimida, har bir policy'ni `before()` orqali aylanib o'tadi |
| `admin`       | Tenant       | Tenant administratori — barcha yozuvlar CRUD, foydalanuvchilarni boshqarish, tasdiqlash |
| `manager`     | Tenant       | Sales/Ops menejer — jamoaning barcha ma'lumotlarini ko'rish va tahrirlash, deal va invoicelarni tasdiqlash |
| `sales`       | Tenant       | Sales vakil — lead → deal → shartnoma funneli uchun javobgar                   |
| `delivery`    | Tenant       | Delivery / PM — loyihalar va tasklarga egalik qiladi                           |
| `finance`     | Tenant       | Moliya — invoice lifecycle, to'lovlar, moliyaviy hisobot                       |
| `viewer`      | Tenant       | Faqat o'qiy oladigan auditor / tashqi stakeholder — ro'yxat va dashboardlar    |

Barcha rol nomlari **snake_case** va `guard_name = web` bilan saqlanadi.
`RoleSeeder`, `User::canAccessPanel()`, `BasePolicy::before()` va
`EnsureTenantContext` o'rtasida aniq mos kelishi kerak.

## Permission formati

Permissionlar **`{resource}.{action}`** dot-notation formatida yoziladi — bu
`BasePolicy` dagi `$user->can($this->resource.'.view')` bilan mos keladi.

**Resurslar:** `accounts`, `contacts`, `leads`, `deals`, `contracts`, `projects`,
`tasks`, `invoices`, `payments`, `reports`, `users`, `tenants`, `roles`, `settings`.

**Standart amallar:** `view`, `create`, `update`, `delete`.

**Workflow amallari:** `leads.convert`, `deals.win`, `deals.lose`, `deals.approve`,
`contracts.sign`, `invoices.send`, `invoices.markPaid`, `invoices.approve`,
`reports.export`, `users.assignRole`.

## Permission matritsasi

Izoh: `C` yaratish · `R` ko'rish · `U` yangilash · `D` o'chirish · `W` workflow · `—` yo'q

| Resurs / amal        | super_admin | admin | manager | sales  | delivery | finance | viewer |
| -------------------- | :---------: | :---: | :-----: | :----: | :------: | :-----: | :----: |
| accounts             |    CRUD     | CRUD  |   RU    |  CRU   |    R     |    R    |   R    |
| contacts             |    CRUD     | CRUD  |   RU    |  CRU   |    R     |    R    |   R    |
| leads                |    CRUD·W   | CRUD·W|  RU·W   | CRU·W  |    —     |    —    |   R    |
| deals                |    CRUD·W   | CRUD·W|  RU·W   | CRU·W  |    —     |    —    |   R    |
| contracts            |    CRUD·W   | CRUD·W|  RU·W   | CRU·W  |    R     |    R    |   R    |
| projects             |    CRUD     | CRUD  |   RU    |   —    |   CRU    |    —    |   R    |
| tasks                |    CRUD     | CRUD  |   RU    |   —    |   CRUD   |    —    |   R    |
| invoices             |    CRUD·W   | CRUD·W|  RU·W   |   —    |    —     |  CRU·W  |   R    |
| payments             |    CRUD     | CRUD  |   R     |   —    |    —     |   CRU   |   R    |
| reports              |    CRUD     |   RE  |   RE    |   —    |    —     |   RE    |   R    |
| users                |    CRUD·W   | CRU·W |   R     |   —    |    —     |    —    |   —    |
| tenants              |    CRUD     |   —   |   —     |   —    |    —     |    —    |   —    |
| roles                |    CRUD     |   —   |   —     |   —    |    —     |    —    |   —    |
| settings             |    CRUD     |  RU   |   —     |   —    |    —     |    —    |   —    |

Workflow ustuni batafsil:

- **leads.convert** — `admin`, `manager`, `sales`
- **deals.win / deals.lose** — `admin`, `sales`
- **deals.approve** — `admin`, `manager`
- **contracts.sign** — `admin`, `manager`, `sales`
- **invoices.send / invoices.markPaid** — `admin`, `finance`
- **invoices.approve** — `admin`, `manager`
- **reports.export** — `admin`, `manager`, `finance`
- **users.assignRole** — `admin` (super_admin bypass orqali)

## Tenant ajratish

Super Admin'ning `tenant_id = null`. U `EnsureTenantContext` va
`BasePolicy::sameTenant()` ni `before()` hook orqali aylanib o'tadi. Qolgan barcha
rollar o'z `tenant_id` siga bog'langan va boshqa tenant ma'lumotlarini ko'ra olmaydi.

## Seed foydalanuvchilar

`database/seeders/UserSeeder.php` lokal/staging uchun har bir rolga bitta foydalanuvchi yaratadi:

| Email                   | Rol           | Parol        | tenant_id |
| ----------------------- | ------------- | ------------ | --------- |
| admin@trustflow.com     | super_admin   | `password`   | `null`    |
| admin@test.com          | admin         | `admin123`   | 1         |
| manager@test.com        | manager       | `manager123` | 1         |
| sales@test.com          | sales         | `sales123`   | 1         |
| delivery@test.com       | delivery      | `delivery123`| 1         |
| finance@test.com        | finance       | `finance123` | 1         |
| viewer@test.com         | viewer        | `viewer123`  | 1         |

**Lokal bo'lmagan muhitga deploy qilishdan oldin barcha parollarni almashtirish shart.**

## Matritsani kengaytirish

1. Yangi permission nomini `RoleSeeder::$permissions` ichiga qo'shing (resource+action massivlari).
2. `$role->syncPermissions([...])` orqali kerakli rolga biriktiring.
3. Policy metodida `$user->can('resource.action')` orqali foydalaning.
4. Konteyner ichida `php artisan migrate:fresh --seed --force` ishga tushiring (yoki
   `scripts/rebuild-and-seed.sh` skriptidan foydalaning).
5. Ushbu hujjatni yangilang — jadval shartnoma hisoblanadi.
