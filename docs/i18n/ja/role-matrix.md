# TrustFlow CRM — 役割マトリクス

> **RBAC の唯一の正規ソース。** コード上は `database/seeders/RoleSeeder.php` が定義し、
> `app/Policies/BasePolicy.php` が強制する。

## 役割の分類

| Role          | スコープ     | 責務                                                                           |
| ------------- | ------------ | ------------------------------------------------------------------------------ |
| `super_admin` | プラットフォーム | 運営者。全テナント横断で操作し、`before()` によりすべてのポリシーを迂回する |
| `admin`       | テナント     | テナント管理者 — すべてのレコードの CRUD、ユーザー管理、承認                   |
| `manager`     | テナント     | セールス/オペレーションマネージャー — チームの全データを閲覧・更新、案件と請求の承認 |
| `sales`       | テナント     | セールス担当 — リード → 案件 → 契約のファネルを担当                            |
| `delivery`    | テナント     | デリバリー/PM — プロジェクトとタスクを担当                                     |
| `finance`     | テナント     | 財務 — 請求ライフサイクル、支払、財務レポート                                  |
| `viewer`      | テナント     | 読み取り専用の監査人/外部ステークホルダー — 一覧とダッシュボードのみ           |

ロール名はすべて **snake_case** かつ `guard_name = web` で保存する。
`RoleSeeder`、`User::canAccessPanel()`、`BasePolicy::before()`、`EnsureTenantContext`
の間で完全に一致する必要がある。

## 権限フォーマット

権限は **`{resource}.{action}`** のドット記法を用いる。これは `BasePolicy` の
`$user->can($this->resource.'.view')` と整合する。

**リソース:** `accounts`, `contacts`, `leads`, `deals`, `contracts`, `projects`,
`tasks`, `invoices`, `payments`, `reports`, `users`, `tenants`, `roles`, `settings`。

**標準アクション:** `view`, `create`, `update`, `delete`。

**ワークフローアクション:** `leads.convert`, `deals.win`, `deals.lose`,
`deals.approve`, `contracts.sign`, `invoices.send`, `invoices.markPaid`,
`invoices.approve`, `reports.export`, `users.assignRole`。

## 権限マトリクス

凡例: `C` 作成 · `R` 閲覧 · `U` 更新 · `D` 削除 · `W` ワークフロー · `—` なし

| リソース             | super_admin | admin | manager | sales  | delivery | finance | viewer |
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

ワークフロー列の詳細:

- **leads.convert** — `admin`, `manager`, `sales`
- **deals.win / deals.lose** — `admin`, `sales`
- **deals.approve** — `admin`, `manager`
- **contracts.sign** — `admin`, `manager`, `sales`
- **invoices.send / invoices.markPaid** — `admin`, `finance`
- **invoices.approve** — `admin`, `manager`
- **reports.export** — `admin`, `manager`, `finance`
- **users.assignRole** — `admin`（`super_admin` はバイパスにより許可）

## テナント分離

Super Admin は `tenant_id = null` を持ち、`EnsureTenantContext` と
`BasePolicy::sameTenant()` を `before()` フックで通過する。他のすべてのロールは
自身の `tenant_id` に閉じ込められ、他テナントのデータを横断参照できない。

## シードユーザー

`database/seeders/UserSeeder.php` がローカル/ステージング用に各ロール 1 名ずつ作成する。

| Email                   | Role          | Password     | tenant_id |
| ----------------------- | ------------- | ------------ | --------- |
| admin@trustflow.com     | super_admin   | `password`   | `null`    |
| admin@test.com          | admin         | `admin123`   | 1         |
| manager@test.com        | manager       | `manager123` | 1         |
| sales@test.com          | sales         | `sales123`   | 1         |
| delivery@test.com       | delivery      | `delivery123`| 1         |
| finance@test.com        | finance       | `finance123` | 1         |
| viewer@test.com         | viewer        | `viewer123`  | 1         |

**本番以外の環境でも、公開する前に必ずローテーションすること。**

## 拡張手順

1. 新しい権限名を `RoleSeeder::$permissions`（リソース＋アクションの配列）に追加する。
2. `$role->syncPermissions([...])` で適切なロールに割り当てる。
3. Policy メソッドで `$user->can('resource.action')` として参照する。
4. コンテナ内で `php artisan migrate:fresh --seed --force` を実行する（または
   `scripts/rebuild-and-seed.sh` を使用）。
5. このドキュメントを更新する — テーブルが契約である。
