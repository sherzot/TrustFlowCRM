# TrustFlow CRM v3.0
## Enterprise B2B Growth Engine

AI-powered, multi-tenant CRM system for managing sales, projects, and finance operations.

### Features

- **Multi-tenant Architecture** - Isolated workspaces for each agency
- **AI-Powered** - Lead scoring, deal prediction, email generation, NLP
- **Sales Pipeline** - Complete lead to deal conversion tracking
- **Project Management** - Time tracking, tasks, Kanban boards
- **Finance Management** - Invoicing, multi-currency, profit tracking
- **Client Portal** - Self-service portal for clients
- **Integrations** - Telegram, WhatsApp, Email, Jira, Xero

### Tech Stack

- Laravel 10
- Filament 3
- MySQL + Redis
- AWS S3
- OpenAI
- Laravel Horizon

### Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan filament:install --panels
```

### License

Proprietary

