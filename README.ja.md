# TrustFlow CRM

[🇬🇧 English](README.md) · 🇯🇵 **日本語** · [🇺🇿 O'zbekcha](README.uz.md)

> B2Bエージェンシーとサービス企業のための、マルチテナント・RBAC駆動型CRM。**Laravel 11 + Filament 3.2** と **TrustFlow Indigo** デザイン言語で構築。

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)
![Filament](https://img.shields.io/badge/Filament-3.2-FFB800?style=flat)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php)
![Docker](https://img.shields.io/badge/Docker-ready-2496ED?style=flat&logo=docker)
![License](https://img.shields.io/badge/license-MIT-green)

---

## TrustFlow CRMとは

**TrustFlow CRM** は、B2Bエージェンシーおよびサービス企業向けの、マルチテナント
CRMプラットフォームです。**セールスパイプライン**(リード → 商談 → 契約)、
**デリバリーパイプライン**(プロジェクト → タスク)、**ファイナンスパイプライン**
(請求書 → 入金 → レポート)を、ロール分離された単一のワークスペースに統合します。

すべてのテナントはデータレイヤーで完全に分離されています。すべてのアクションは
明示的なドット記法の権限で制御され、すべての画面(ダッシュボードKPIからカンバン
ボードまで)は、B2B業務に求められる信頼性のあるトーンに調整された
**TrustFlow Indigo** デザイン言語でスタイリングされています。

---

## 主な機能

### マルチテナンシー(設計に組み込み済み)
すべてのテナントスコープモデルで `BelongsToTenant` トレイトと `TenantScope`
グローバルスコープを使用。`EnsureTenantContext` ミドルウェアと
`BasePolicy::sameTenant()` が、リクエストごと・ポリシーチェックごとに分離を強制
します。`super_admin`(`tenant_id = null`)はプラットフォーム運用のため明示的に許可。

### 7ロールRBAC + ワークフロー権限
正規化された7ロールマトリクス(`super_admin`, `admin`, `manager`, `sales`,
`delivery`, `finance`, `viewer`)と、ドット記法の権限(`deals.view`,
`invoices.approve`, `leads.convert`…)。**信頼できる唯一の情報源** として
[`docs/roles/role-matrix.md`](docs/roles/role-matrix.md) にドキュメント化。

### セールス・デリバリー・ファイナンスを1つのパネルで
- **セールス** — アカウント、コンタクト、リード、商談、契約、カンバンボード。
- **デリバリー** — プロジェクト、タスク、進捗追跡、タイムエントリー。
- **ファイナンス** — 請求書、マルチ通貨、承認、入金ワークフロー。
- **アナリティクス** — `TrustFlowKpiWidget`(MTD売上、パイプライン、勝率、
  未払請求書)、セールスファネル、利益チャート、OKRダッシュボード。

### AIサービスレイヤー
`AIService` ファサード、タイムアウト+リトライ付きの `OpenAIClient`、
バージョン管理された `PromptTemplates`、すべての呼び出しを `ai_calls` テーブルに
永続化してコスト帰属できる `AiCallLogger`。リードスコアリング、商談予測、
メール文案生成にすぐ使える設計です。

### TrustFlow Indigo デザイン言語
主要色にインディゴ、中立色にスレート、成功にエメラルド、警告にアンバー、
危険にローズ、情報にスカイ。タブラーナム付きInterフォント。洗練されたサイドバー、
トップバー、テーブル。Filament レンダーフック経由で読み込まれ
**Vite ビルド不要** です。

### 多言語対応
UIは **English / 日本語 / O'zbekcha / Русский**。ドキュメントは英語が正本で、
[`docs/i18n/`](docs/i18n/) に三言語のロールマトリクスコピーを配置。

### 運用可能な状態で提供
Docker Compose スタック(nginx + php-fpm + MySQL + Redis + Horizon + scheduler)、
GitHub Actions CI(Pint + PHPStan level 6 + テスト)、オンプレミス向けの
ミラー `Jenkinsfile`、そして [`k8s/`](k8s/) 以下の K8s リファレンスマニフェスト。

---

## アーキテクチャ

```
┌─────────────────────────────────────────────────────────────┐
│                      Filament 管理パネル                      │
│   セールス · デリバリー · ファイナンス · 分析 · システム        │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│  EnsureTenantContext ─►  BasePolicy (before + sameTenant)    │
│            ▼                        ▼                        │
│   TenantScope (global)       ドット記法の権限                  │
└─────────────────────────────────────────────────────────────┘
                              │
          ┌───────────────────┼───────────────────┐
          ▼                   ▼                   ▼
   ┌────────────┐      ┌────────────┐      ┌────────────┐
   │   MySQL    │      │   Redis    │      │  AI 層     │
   │ (テナント   │      │ (キャッシュ │      │ OpenAI +   │
   │  スコープ)  │      │  + キュー) │      │ 呼び出しログ│
   └────────────┘      └────────────┘      └────────────┘
```

詳細: [`docs/architecture/overview.md`](docs/architecture/overview.md)。

---

## 技術スタック

| レイヤー | 技術 |
| --- | --- |
| バックエンド | Laravel 11 (PHP 8.2+) |
| 管理 UI | Filament 3.2 |
| データベース | MySQL 8 |
| キャッシュ / キュー | Redis 7 + Horizon |
| RBAC | spatie/laravel-permission |
| AI | OpenAI (`App\Services\AI\OpenAIClient` 経由) |
| テスト | Pest / PHPUnit |
| 静的解析 | Larastan (level 6) |
| フォーマッター | Laravel Pint (strict types) |
| コンテナ | Docker + Docker Compose |
| オーケストレーション | Kubernetes (`k8s/` にリファレンスマニフェスト) |
| CI/CD | GitHub Actions + Jenkins |

---

## クイックスタート (Docker)

```bash
# 1. クローン
git clone https://github.com/sherzot/TrustFlowCRM.git
cd TrustFlowCRM

# 2. 環境変数をコピー
cp .env.example .env

# 3. フルリビルド + シード (Docker build + migrate:fresh --seed + 検証)
./scripts/rebuild-and-seed.sh

# 4. 開く
open http://localhost:18080
```

デフォルトの Super Admin: `admin@trustflow.com` / `password` ·
全シードユーザー表: [`docs/README.md#canonical-seed-users`](docs/README.md#canonical-seed-users-local--staging-only)。

> ローカル以外の環境にデプロイする前に、すべてのシード認証情報をローテーション
> してください。

手動セットアップは [`docs/deployment/setup.md`](docs/deployment/setup.md) を参照。

---

## ロール一覧

| ロール | スコープ | 主な責任 |
| --- | --- | --- |
| `super_admin` | プラットフォーム | クロステナント運用者、`before()` ですべてのポリシーをバイパス |
| `admin` | テナント | テナント内のフル CRUD + ユーザー管理 + 承認 |
| `manager` | テナント | セールス/オペレーション責任者 — 商談・請求書のレビューと承認 |
| `sales` | テナント | リード → 商談 → 契約のファネルを所有 |
| `delivery` | テナント | 契約後のプロジェクトとタスクを所有 |
| `finance` | テナント | 請求書ライフサイクル、入金、財務レポート |
| `viewer` | テナント | 読み取り専用の監査者 / 外部ステークホルダー |

すべての権限とワークフロールールを含む完全なマトリクス:
[`docs/roles/role-matrix.md`](docs/roles/role-matrix.md)。
ローカライズ版: [🇯🇵 JA](docs/i18n/ja/role-matrix.md) · [🇺🇿 UZ](docs/i18n/uz/role-matrix.md)。

---

## デザイン言語 — TrustFlow Indigo

信頼性が求められる SaaS 向けに洗練された、プロフェッショナルなパレット。

| トークン | 色 | 用途 |
| --- | --- | --- |
| `primary` | インディゴ | ブランド、主要 CTA、アクティブなサイドバー項目 |
| `gray` | スレート | 中立キャンバス、本文テキスト、罫線 |
| `success` | エメラルド | 成約した商談、支払済請求書 |
| `warning` | アンバー | リスクあり、期限超過 |
| `danger` | ローズ | 失注、失敗 |
| `info` | スカイ | 情報バナー |

Linear の明瞭さ、Attio の抑制、Notion の仕上げに触発されました。
テーマ CSS: [`public/css/trustflow-theme.css`](public/css/trustflow-theme.css) —
[`AdminPanelProvider`](app/Providers/Filament/AdminPanelProvider.php) で
Filament `STYLES_AFTER` レンダーフック経由で読み込み。**Vite ビルド不要**。

---

## ドキュメント

エンジニアリング、運用、オンボーディングのすべての資料は
[`docs/`](docs/README.md) 以下に配置されています:

```
docs/
├── README.md                  ドキュメントホーム
├── architecture/overview.md   システムアーキテクチャと境界
├── roles/
│   ├── role-matrix.md         正規の 7 ロール RBAC マトリクス
│   └── legacy-rbac.md         旧権限モデル
├── deployment/
│   ├── setup.md               ローカル開発ブートストラップ
│   ├── docker.md              Docker スタック内部
│   └── deployment.md          ステージング / 本番ランブック
├── changelog/
│   ├── v3-upgrade.md          v2 → v3 アップグレードノート
│   └── v3-upgrade.patch       差分キャプチャ
└── i18n/
    ├── ja/role-matrix.md      役割マトリクス (日本語)
    └── uz/role-matrix.md      Rol matritsasi (o'zbekcha)
```

リリース履歴: [`CHANGELOG.md`](CHANGELOG.md) (Keep a Changelog 1.1.0 · SemVer 2.0.0)。

---

## 運用スクリプト

| スクリプト | 目的 |
| --- | --- |
| [`scripts/rebuild-and-seed.sh`](scripts/rebuild-and-seed.sh) | Docker フルリビルド + `migrate:fresh --seed` + Super Admin 検証。RBAC またはテーマ変更後に実行。 |
| [`scripts/publish-to-github.sh`](scripts/publish-to-github.sh) | 事前準備された git-bundle のコミットを `origin/main` に公開。サンドボックスセッションでコミットを準備する際に使用。 |

---

## コントリビューション

1. 大きな変更の前に issue またはディスカッションを開いてください。
2. コード規約: `composer pint` + `composer phpstan` が通る必要があります。
3. RBAC 変更 → [`docs/roles/role-matrix.md`](docs/roles/role-matrix.md)、
   `RoleSeeder`、および i18n コピーを更新。
4. スキーマ変更 → マイグレーションを書き、再シードし、破壊的変更を
   [`docs/changelog/`](docs/changelog/) に記載、[`CHANGELOG.md`](CHANGELOG.md) に
   エントリーを追加。
5. 論理的な変更ごとに1つの conventional commit(`feat:`, `fix:`, `docs:`,
   `chore(devops):`, …)。

---

## ライセンス

[MIT License](LICENSE) の下でリリースされています。

---

## リンク

- **リポジトリ:** https://github.com/sherzot/TrustFlowCRM
- **ドキュメントホーム:** [`docs/README.md`](docs/README.md)
- **チェンジログ:** [`CHANGELOG.md`](CHANGELOG.md)
- **メンテナー:** [@sherzot](https://github.com/sherzot)
