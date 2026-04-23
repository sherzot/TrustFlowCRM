# TrustFlow CRM — Role Matrix

> **Canonical source of truth for RBAC.** Defined in code by `database/seeders/RoleSeeder.php`
> and enforced by `app/Policies/BasePolicy.php`.

## Role taxonomy

| Role          | Scope         | Responsibility                                                              |
| ------------- | ------------- | --------------------------------------------------------------------------- |
| `super_admin` | Platform      | Platform operator, cross-tenant ops, bypasses every policy via `before()`   |
| `admin`       | Tenant        | Tenant administrator — CRUD every record, manage users, approvals           |
| `manager`     | Tenant        | Sales / Ops manager — view & edit all team data, approve deals and invoices |
| `sales`       | Tenant        | Sales rep — owns lead → deal → contract funnel                              |
| `delivery`    | Tenant        | Delivery / PM — owns projects and tasks                                     |
| `finance`     | Tenant        | Finance — invoice lifecycle, payments, financial reporting                  |
| `viewer`      | Tenant        | Read-only auditor / external stakeholder — lists & dashboards only          |

All role names are stored **snake_case** with `guard_name = web`. They must match exactly
between `RoleSeeder`, `User::canAccessPanel()`, `BasePolicy::before()`, and
`EnsureTenantContext`.

## Permission format

Permissions follow **`{resource}.{action}`** dot notation so they line up with
`$user->can($this->resource.'.view')` in `BasePolicy`.

**Resources:** `accounts`, `contacts`, `leads`, `deals`, `contracts`, `projects`,
`tasks`, `invoices`, `payments`, `reports`, `users`, `tenants`, `roles`, `settings`.

**Standard actions:** `view`, `create`, `update`, `delete`.

**Workflow actions:** `leads.convert`, `deals.win`, `deals.lose`, `deals.approve`,
`contracts.sign`, `invoices.send`, `invoices.markPaid`, `invoices.approve`,
`reports.export`, `users.assignRole`.

## Permission matrix

Legend: `C` create · `R` view · `U` update · `D` delete · `W` workflow action · `—` none

| Resource / action    | super_admin | admin | manager | sales  | delivery | finance | viewer |
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

Workflow column details:

- **leads.convert** — `admin`, `manager`, `sales`
- **deals.win / deals.lose** — `admin`, `sales`
- **deals.approve** — `admin`, `manager`
- **contracts.sign** — `admin`, `manager`, `sales`
- **invoices.send / invoices.markPaid** — `admin`, `finance`
- **invoices.approve** — `admin`, `manager`
- **reports.export** — `admin`, `manager`, `finance`
- **users.assignRole** — `admin` (plus super_admin via bypass)

## Tenant isolation

Super Admin has `tenant_id = null` and is allowed through `EnsureTenantContext` and
`BasePolicy::sameTenant()` via the `before()` hook. Every other role is scoped to
their own `tenant_id` and cannot cross-read.

## Seed users

`database/seeders/UserSeeder.php` creates one user per role for local / staging:

| Email                   | Role          | Password     | tenant_id |
| ----------------------- | ------------- | ------------ | --------- |
| admin@trustflow.com     | super_admin   | `password`   | `null`    |
| admin@test.com          | admin         | `admin123`   | 1         |
| manager@test.com        | manager       | `manager123` | 1         |
| sales@test.com          | sales         | `sales123`   | 1         |
| delivery@test.com       | delivery      | `delivery123`| 1         |
| finance@test.com        | finance       | `finance123` | 1         |
| viewer@test.com         | viewer        | `viewer123`  | 1         |

**Rotate these before any non-local deployment.**

## Extending the matrix

1. Add the new permission name(s) to `RoleSeeder::$permissions` (resource+actions arrays).
2. Assign to the right role via `$role->syncPermissions([...])`.
3. Reference in a Policy method via `$user->can('resource.action')`.
4. Run `php artisan migrate:fresh --seed --force` in the container (or the helper
   `scripts/rebuild-and-seed.sh`).
5. Update this document — the table is the contract.
