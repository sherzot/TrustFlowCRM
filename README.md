# TrustFlow CRM v3.0
## Enterprise B2B Growth Engine

AI-powered, multi-tenant CRM system for managing sales, projects, and finance operations with full multi-language support.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)
![Filament](https://img.shields.io/badge/Filament-3.2+-FFB800?style=flat)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker)

## ✨ Features

### Core Features
- **Multi-tenant Architecture** - Isolated workspaces for each agency
- **Multi-Language Support** - Japanese (main), English, Russian with dynamic switching
- **Role-Based Access Control (RBAC)** - 6 roles with granular permissions
- **Locale-based Date Formatting** - Automatic date format based on language
- **AI-Powered** - Lead scoring, deal prediction, email generation, NLP
- **Sales Pipeline** - Complete lead to deal conversion tracking
- **Project Management** - Time tracking, tasks, Kanban boards
- **Finance Management** - Invoicing, multi-currency, profit tracking
- **Analytics & Reporting** - Sales funnel, profit charts, OKR dashboard
- **System Health Monitoring** - Real-time system component status
- **Performance Optimized** - Redis caching, database indexes, eager loading

### Filament Resources
- ✅ Accounts - Company/Account management
- ✅ Contacts - Contact person management
- ✅ Leads - Lead management with AI scoring
- ✅ Deals - Deal/opportunity management with Kanban board
- ✅ Projects - Project management with progress tracking
- ✅ Tasks - Task management with priorities
- ✅ Invoices - Invoice management with multi-currency

### Custom Pages
- 📊 **Dashboard** - Main dashboard with widgets
- 📋 **Kanban Board** - Visual deal pipeline management
- 🎯 **OKR Dashboard** - Objectives and Key Results tracking
- 💚 **System Health** - System component monitoring
- 🌐 **Language Settings** - Multi-language switcher

### Widgets
- 🤖 AI Insights - AI-powered metrics and insights
- 📈 Sales Funnel - Sales pipeline visualization
- 💰 Profit Chart - Revenue/cost/profit analysis

## 🚀 Tech Stack

- **Backend**: Laravel 11
- **Admin Panel**: Filament 3.2+
- **Database**: MySQL 8.0 + Redis 7
- **Queue**: Laravel Horizon 5.21
- **Storage**: AWS S3 / Local
- **AI**: OpenAI GPT-4
- **Multi-tenancy**: Stancl Tenancy v3.0
- **Permissions**: Spatie Laravel Permission v6.0
- **Media**: Spatie Laravel Media Library v11.0
- **Containerization**: Docker & Docker Compose
- **CI/CD**: GitHub Actions

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        TrustFlow CRM v3.0                        │
│                    Enterprise B2B Growth Engine                  │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                         Client Layer                            │
├─────────────────────────────────────────────────────────────────┤
│  Web Browser → Nginx (Port 8080) → PHP-FPM (Port 9000)         │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│                      Application Layer                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │              Filament Admin Panel (v3.2+)                │  │
│  ├──────────────────────────────────────────────────────────┤  │
│  │  Resources: Accounts, Contacts, Leads, Deals,           │  │
│  │             Projects, Tasks, Invoices                    │  │
│  │  Pages: Dashboard, Kanban, OKR, System Health, Locale    │  │
│  │  Widgets: AI Insights, Sales Funnel, Profit Chart       │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                 │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │              Laravel Framework (v11)                     │  │
│  ├──────────────────────────────────────────────────────────┤  │
│  │  • Multi-Language (ja, en, ru)                           │  │
│  │  • RBAC (6 Roles: Super Admin, Admin, Manager,          │  │
│  │    Sales, Delivery, Finance)                            │  │
│  │  • Multi-Tenancy (Stancl Tenancy v3.0)                  │  │
│  │  • Date Formatting (Locale-based)                       │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                 │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │              Domain Services                              │  │
│  ├──────────────────────────────────────────────────────────┤  │
│  │  • SalesService      - Lead conversion, Deal management │  │
│  │  • DeliveryService   - Project & Task management        │  │
│  │  • FinanceService    - Invoice & Payment processing     │  │
│  │  • AnalyticsService  - Reporting & Insights             │  │
│  │  • IntegrationService - External API integrations        │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                 │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │              AI Services                                  │  │
│  ├──────────────────────────────────────────────────────────┤  │
│  │  • Lead Scoring      - Automatic quality assessment      │  │
│  │  • Deal Prediction   - Success probability calculation   │  │
│  │  • Email Generation  - AI-generated content              │  │
│  │  • NLP Processing    - Natural language understanding    │  │
│  │  • Risk Detection    - Deal risk analysis                │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│                      Data Layer                                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────────┐         ┌──────────────────┐             │
│  │   MySQL 8.0      │         │   Redis 7       │             │
│  │   (Port 3306)    │         │   (Port 6379)   │             │
│  ├──────────────────┤         ├──────────────────┤             │
│  │ • Core Tables    │         │ • Cache          │             │
│  │ • System Tables  │         │ • Session        │             │
│  │ • Indexes        │         │ • Queue          │             │
│  └──────────────────┘         └──────────────────┘             │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│                    Background Processing                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │         Laravel Horizon (Queue Worker)                  │  │
│  ├──────────────────────────────────────────────────────────┤  │
│  │  • AI Processing Jobs                                    │  │
│  │  • Email Notifications                                   │  │
│  │  • Data Synchronization                                  │  │
│  │  • Report Generation                                     │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                    External Services                             │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐         │
│  │   OpenAI     │  │   AWS S3     │  │  Telegram    │         │
│  │   (GPT-4)    │  │   (Storage)  │  │  (Notif.)    │         │
│  └──────────────┘  └──────────────┘  └──────────────┘         │
│                                                                 │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐         │
│  │   Jira       │  │   Xero       │  │  WhatsApp    │         │
│  │   (Tasks)    │  │   (Accounting)│  │  (Messaging) │         │
│  └──────────────┘  └──────────────┘  └──────────────┘         │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                    Data Flow                                     │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Web-to-Lead                                                    │
│      ↓                                                          │
│  Lead (AI Scored)                                              │
│      ↓                                                          │
│  Account + Contact                                             │
│      ↓                                                          │
│  Deal (AI Scored, Kanban Board)                                │
│      ↓                                                          │
│  Project (Time Tracked, Tasks)                                 │
│      ↓                                                          │
│  Invoice (Auto-generated)                                      │
│      ↓                                                          │
│  Revenue (ROI & Profit Tracked)                                │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                    Security & Access Control                     │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Authentication: Filament Auth                                 │
│      ↓                                                          │
│  Authorization: Spatie Permission (RBAC)                      │
│      ↓                                                          │
│  Data Isolation: Multi-Tenancy (tenant_id)                     │
│      ↓                                                          │
│  Role-Based Navigation & Actions                               │
│                                                                 │
│  Roles:                                                        │
│  • Super Admin → All resources, all tenants                   │
│  • Admin → All resources, own tenant, no delete              │
│  • Manager → View & edit only, own tenant                     │
│  • Sales → Sales resources only (Accounts, Contacts, Leads,   │
│            Deals)                                             │
│  • Delivery → Delivery resources only (Projects, Tasks)       │
│  • Finance → Finance resources only (Invoices)                │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

## 📋 Requirements

- PHP 8.2+
- Composer
- Docker & Docker Compose (for containerized setup)
- MySQL 8.0+
- Redis 7+
- Node.js & NPM (for asset compilation)

## 🛠️ Installation

### Quick Start with Docker (Recommended)

```bash
# Clone repository
git clone https://github.com/sherzot/TrustFlowCRM.git
cd TrustFlowCRM

# Copy environment file
cp .env.example .env

# Edit .env file with your configuration
# Set database credentials, OpenAI API key, etc.

# Start Docker containers
docker-compose up -d

# Install dependencies
docker-compose exec app composer install

# Generate application key
docker-compose exec app php artisan key:generate

# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Clear cache
docker-compose exec app php artisan optimize:clear
```

### Local Development Setup

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure .env file
# Set database credentials, OpenAI API key, etc.

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Start queue worker
php artisan horizon
```

## ⚙️ Configuration

### Environment Variables

Copy `.env.example` to `.env` and configure the following variables:

**Required Variables:**
- `APP_KEY` - Application encryption key (generated automatically)
- `DB_HOST` - Database host (`db` for Docker, `localhost` for local)
- `DB_DATABASE` - Database name
- `DB_USERNAME` - Database username
- `DB_PASSWORD` - Database password
- `REDIS_HOST` - Redis host (`redis` for Docker, `127.0.0.1` for local)

**Optional Variables:**
- `OPENAI_API_KEY` - OpenAI API key for AI features
- `AWS_ACCESS_KEY_ID` - AWS S3 access key (if using S3)
- `AWS_SECRET_ACCESS_KEY` - AWS S3 secret key (if using S3)
- `AWS_BUCKET` - AWS S3 bucket name (if using S3)

> ⚠️ **Security Note**: Never commit your `.env` file to version control. Always use `.env.example` as a template and keep your actual credentials secure.

### Docker Services

The application runs in Docker with the following services:

- **app** - PHP-FPM 8.2 application (port 9000)
- **nginx** - Web server (port 8080)
- **db** - MySQL 8.0 database (port 3306)
- **redis** - Redis cache/queue (port 6379)
- **horizon** - Laravel Horizon queue worker

Access the application at: `http://localhost:8080/admin`

## 🌐 Multi-Language Support

### Supported Languages
- 🇯🇵 **Japanese (ja)** - Main language
- 🇬🇧 **English (en)** - Fallback language
- 🇷🇺 **Russian (ru)** - Additional language

### Switching Language

1. Log in to admin panel
2. Navigate to **Settings → Language Settings** (言語設定)
3. Select your preferred language
4. All pages, resources, and labels will update automatically

### Translation Files

- `resources/lang/{locale}/filament.php` - Filament-specific translations
- `resources/lang/{locale}/common.php` - Common translations

All Filament Resources and Pages are fully translated.

### Date Formatting

Dates are automatically formatted based on current locale:
- **Japanese**: `2025年12月29日` (Y年m月d日)
- **English/Russian**: `2025.12.29` (Y.m.d)
- **DateTime**: Includes time component (H:i)
- Applied to all DatePicker components and table columns

## 🔐 Role-Based Access Control (RBAC)

The system implements comprehensive RBAC with 6 roles:

### Roles & Permissions

1. **Super Admin** - Full access to all resources and tenants
2. **Admin** - Full access to own tenant (view, create, edit - no delete)
3. **Manager** - Read-only with edit capability (no create, no delete)
4. **Sales** - Sales resources only (Accounts, Contacts, Leads, Deals)
5. **Delivery** - Delivery resources only (Projects, Tasks)
6. **Finance** - Finance resources only (Invoices)

### Features

- **Navigation Visibility** - Resources visible based on permissions
- **Action Permissions** - Create, edit, delete actions checked per role
- **Page Visibility** - Custom pages respect role permissions
- **Widget Visibility** - Widgets show data based on role access

See `ROLE_BASED_ACCESS.md` for detailed permission matrix.

## 👥 Default Users

After seeding, the following test users are created:

- **Super Admin**: `admin@trustflow.com` / `password`
- **Admin**: `admin@test.com` / `admin123`
- **Manager**: `manager@test.com` / `manager123`
- **Sales**: `sales@test.com` / `sales123`
- **Delivery**: `delivery@test.com` / `delivery123`
- **Finance**: `finance@test.com` / `finance123`

> ⚠️ **Security Note**: Change default passwords immediately after first login in production environments.

## 📚 Usage

### Access Admin Panel

1. Navigate to `http://localhost:8080/admin`
2. Log in with default credentials
3. Start managing your CRM data

### Key Workflows

#### Lead Management
1. Create a Lead from web form or manually
2. AI automatically scores the lead
3. Convert Lead to Account + Contact
4. Create Deal from Account
5. Track Deal through Kanban board stages

#### Project Management
1. Create Project from won Deal
2. Add Tasks to Project
3. Track time and progress
4. Generate Invoice when complete

#### Analytics
- View Sales Funnel on Dashboard
- Check OKR Dashboard for objectives
- Monitor System Health
- Review AI Insights

## 🐳 Docker Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f app

# Execute commands in app container
docker-compose exec app php artisan migrate
docker-compose exec app composer install

# Access MySQL (replace with your credentials)
docker-compose exec db mysql -u YOUR_DB_USERNAME -pYOUR_DB_PASSWORD YOUR_DB_NAME

# Access Redis CLI
docker-compose exec redis redis-cli
```

## 🔧 Development

### Code Style
- Laravel Pint for code formatting
- PSR-12 coding standards

### Running Tests
```bash
php artisan test
```

### Queue Processing
```bash
# Using Horizon (recommended)
php artisan horizon

# Or using queue worker
php artisan queue:work
```

### Clearing Cache
```bash
php artisan optimize:clear
```

## 📦 Deployment

### Docker Hub

The application is automatically built and pushed to Docker Hub:

- **Image**: `sherdev/trustflow-crm:latest`
- **Tag**: `sherdev/trustflow-crm:v3.0`

### Production Deployment

1. Pull Docker image: `docker pull sherdev/trustflow-crm:latest`
2. Configure production `.env` file
3. Run migrations: `php artisan migrate`
4. Seed initial data: `php artisan db:seed`
5. Start Horizon: `php artisan horizon`
6. Configure web server (Nginx/Apache)
7. Set up SSL certificates

## 🔐 Security

- CSRF protection enabled
- Authentication via Filament
- Role-based access control (RBAC)
- Tenant data isolation
- Password hashing (bcrypt)
- API token authentication (Sanctum)

### Security Best Practices

- ⚠️ **Never commit `.env` file** - Contains sensitive credentials
- ⚠️ **Change default passwords** - Update default user passwords after installation
- ⚠️ **Use strong passwords** - For database, Redis, and admin accounts
- ⚠️ **Keep API keys secure** - Store OpenAI and AWS keys securely
- ⚠️ **Set `APP_DEBUG=false`** - In production environments
- ⚠️ **Use HTTPS** - Always use SSL/TLS in production

## 📊 Monitoring

- **System Health Page** - Monitor database, cache, queue, storage
- **Horizon Dashboard** - Queue monitoring at `/admin/horizon`
- **Activity Log** - User action tracking
- **Error Logging** - Laravel log files

## ⚡ Performance

The system is optimized for performance:

- **Redis Caching** - Default cache driver
- **Database Indexing** - Comprehensive indexes on tenant_id, status, foreign keys
- **Eager Loading** - All relationships loaded to prevent N+1 queries
- **Queue Processing** - Background jobs via Laravel Horizon
- **Optimized Queries** - Composite indexes for common query patterns

## 🛠️ Helper Classes

### DateHelper
- Locale-aware date formatting
- Automatic format switching based on language
- Used in all DatePicker components and table columns

### TenantHelper
- Tenant management utilities
- Ensures default tenant exists
- Handles tenant_id assignment for Super Admin users

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

Proprietary

## 🔗 Links

- **GitHub**: https://github.com/sherzot/TrustFlowCRM
- **Docker Hub**: https://hub.docker.com/r/sherdev/trustflow-crm
- **Documentation**: See `ARCHITECTURE.md` for detailed architecture

## 📞 Support

For support, please open an issue on GitHub.

---

**TrustFlow CRM v3.0** - Enterprise B2B Growth Engine 🚀
