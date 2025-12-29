# TrustFlow CRM v3.0 Architecture

## Project Structure

```
trustflow-crm/
├── app/
│   ├── Domains/
│   │   ├── Sales/          # Sales domain logic
│   │   ├── Delivery/       # Project delivery logic
│   │   ├── Finance/        # Finance & invoicing logic
│   │   ├── Analytics/      # Analytics & reporting
│   │   └── Integration/    # External integrations
│   ├── Filament/
│   │   ├── Resources/      # Filament CRUD resources
│   │   │   ├── AccountResource.php
│   │   │   ├── ContactResource.php
│   │   │   ├── LeadResource.php
│   │   │   ├── DealResource.php
│   │   │   ├── ProjectResource.php
│   │   │   ├── TaskResource.php
│   │   │   └── InvoiceResource.php
│   │   ├── Pages/          # Custom pages
│   │   │   ├── CustomDashboard.php
│   │   │   ├── KanbanBoard.php
│   │   │   ├── OKRDashboard.php
│   │   │   ├── SystemHealth.php
│   │   │   └── LocaleSwitcher.php
│   │   └── Widgets/        # Dashboard widgets
│   │       ├── AIInsightsWidget.php
│   │       ├── SalesFunnelWidget.php
│   │       └── ProfitChartWidget.php
│   ├── Http/
│   │   └── Middleware/
│   │       └── SetLocale.php  # Multi-language middleware
│   ├── Helpers/            # Helper classes
│   │   ├── DateHelper.php  # Locale-based date formatting
│   │   └── TenantHelper.php # Tenant management helpers
│   ├── Models/             # Eloquent models
│   ├── Services/           # AI services
│   ├── Observers/          # Model observers
│   ├── Jobs/               # Background jobs
│   └── Policies/           # Authorization policies
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
│       ├── RoleSeeder.php
│       ├── UserSeeder.php
│       └── TenantSeeder.php
├── resources/
│   ├── lang/               # Multi-language translations
│   │   ├── ja/             # Japanese (main language)
│   │   │   ├── common.php
│   │   │   └── filament.php
│   │   ├── en/             # English
│   │   │   ├── common.php
│   │   │   └── filament.php
│   │   └── ru/             # Russian
│   │       ├── common.php
│   │       └── filament.php
│   └── views/
│       └── filament/
│           └── pages/      # Custom page views
├── docker/                 # Docker configuration
│   ├── nginx/
│   ├── php/
│   └── mysql/
├── .github/
│   └── workflows/          # CI/CD pipelines
│       └── docker-build.yml
└── config/                 # Configuration files
```

## Key Features

### 1. Multi-Tenant Architecture
- Each agency has isolated workspace
- Tenant-based data segregation
- Custom domains support
- Stancl Tenancy v3.0 integration

### 2. Multi-Language Support
- **Japanese (ja)** - Main language
- **English (en)** - Secondary language
- **Russian (ru)** - Third language
- Dynamic language switching via LocaleSwitcher page
- SetLocale middleware for automatic locale detection
- All Filament Resources and Pages fully translated
- Translation files: `resources/lang/{locale}/filament.php`
- **Locale-based Date Formatting**: 
  - Japanese: `2025年12月29日` (Y年m月d日)
  - English/Russian: `2025.12.29` (Y.m.d)
  - Applied to all DatePicker components and date columns

### 3. AI-Powered Features
- **Lead Scoring**: Automatic lead quality scoring
- **Deal Prediction**: Success probability prediction
- **Email Generation**: AI-generated email content
- **NLP**: Natural language question answering
- **Risk Detection**: Deal risk analysis

### 4. Sales Pipeline
- Lead → Account → Contact → Deal → Project → Invoice
- Full history tracking
- AI scoring at each stage
- Kanban board visualization
- Deal conversion workflow

### 5. Project Management
- Time tracking
- Task management
- Progress tracking
- Profit calculation
- Project status management

### 6. Finance Management
- Multi-currency support (USD, EUR, GBP)
- Automatic invoicing
- Profit & ROI tracking
- Payment tracking
- Tax calculation

### 7. Analytics & Reporting
- Sales funnel visualization
- Profit charts
- OKR dashboard
- AI insights widget
- System health monitoring

### 8. Integrations
- Telegram notifications
- WhatsApp messaging
- Jira integration
- Xero accounting sync
- Email inbound processing

## Technology Stack

- **Backend**: Laravel 11
- **Admin Panel**: Filament 3.2+
- **Database**: MySQL 8.0 + Redis 7
- **Queue**: Laravel Horizon 5.21
- **Storage**: AWS S3 / Local
- **AI**: OpenAI GPT-4 (via openai-php/laravel)
- **Multi-tenancy**: Stancl Tenancy v3.0
- **Permissions**: Spatie Laravel Permission v6.0
- **Media**: Spatie Laravel Media Library v11.0
- **Activity Log**: Spatie Laravel Activity Log v4.8
- **PDF**: DomPDF v2.0
- **Containerization**: Docker & Docker Compose
- **CI/CD**: GitHub Actions

## Docker Architecture

### Services
1. **app** - PHP-FPM 8.2 application container
2. **nginx** - Web server (port 8080)
3. **db** - MySQL 8.0 database (port 3306)
4. **redis** - Redis cache/queue (port 6379)
5. **horizon** - Laravel Horizon queue worker

### Volumes
- `dbdata` - MySQL persistent storage
- `redisdata` - Redis persistent storage

### Networks
- `trustflow-network` - Bridge network for inter-container communication

## User Roles & Permissions

### Role-Based Access Control (RBAC)

The system implements comprehensive RBAC with the following roles:

1. **Super Admin** (`super_admin`)
   - Platform owner, manages all tenants
   - No `tenant_id` (can access all tenants)
   - All permissions: view, create, edit, delete
   - Access to all resources and system pages

2. **Admin** (`admin`)
   - Manages agency settings and OKRs
   - Own tenant only (`tenant_id` required)
   - Permissions: view, create, edit (no delete)
   - Access to all resources except system management

3. **Manager** (`manager`)
   - Read-only access with edit capability
   - Own tenant only
   - Permissions: view, edit (no create, no delete)
   - Can view all resources but cannot create or delete

4. **Sales** (`sales`)
   - Sales-focused role
   - Own tenant only
   - Permissions: view, create, edit for Sales resources only
   - Resources: Accounts, Contacts, Leads, Deals
   - Hidden: Projects, Tasks, Invoices

5. **Delivery** (`delivery`)
   - Project delivery focused
   - Own tenant only
   - Permissions: view, create, edit for Delivery resources only
   - Resources: Projects, Tasks
   - Hidden: Accounts, Contacts, Leads, Deals, Invoices

6. **Finance** (`finance`)
   - Finance-focused role
   - Own tenant only
   - Permissions: view, create, edit for Finance resources only
   - Resources: Invoices
   - Hidden: All other resources

### Permission System

- **Permissions**: Managed via Spatie Laravel Permission
- **Navigation Visibility**: Resources visible based on `view {resource}` permission
- **Action Permissions**: Create, edit, delete actions checked per role
- **Page Visibility**: Custom pages check permissions before displaying
- **Widget Visibility**: Widgets respect role-based access

### Implementation

- All Resources implement `shouldRegisterNavigation()`, `canViewAny()`, `canCreate()`
- Table actions use `visible()` closures for permission checks
- Edit pages implement `canDelete()` method
- Custom pages implement `shouldRegisterNavigation()` for visibility control

## Filament Resources

All resources support multi-language and tenant isolation:

1. **AccountResource** - Company/Account management
2. **ContactResource** - Contact person management
3. **LeadResource** - Lead management with AI scoring
4. **DealResource** - Deal/opportunity management
5. **ProjectResource** - Project management
6. **TaskResource** - Task management
7. **InvoiceResource** - Invoice management

## Custom Pages

1. **CustomDashboard** - Main dashboard with translated navigation
2. **KanbanBoard** - Visual deal pipeline management
3. **OKRDashboard** - Objectives and Key Results tracking
4. **SystemHealth** - System health monitoring
5. **LocaleSwitcher** - Language selection page

## Widgets

1. **AIInsightsWidget** - AI-powered insights and metrics
2. **SalesFunnelWidget** - Sales funnel visualization
3. **ProfitChartWidget** - Profit/revenue/cost charts

## Data Flow

```
Web-to-Lead → Lead (AI Scored)
    ↓
Account + Contact
    ↓
Deal (AI Scored, Kanban)
    ↓
Project (Time Tracked, Tasks)
    ↓
Invoice (Auto-generated)
    ↓
Revenue (ROI & Profit Tracked)
```

## Installation

### Using Docker (Recommended)

1. Clone repository: `git clone https://github.com/sherzot/TrustFlowCRM.git`
2. Copy `.env.example` to `.env`
3. Configure environment variables in `.env`
4. Start containers: `docker-compose up -d`
5. Install dependencies: `docker-compose exec app composer install`
6. Generate key: `docker-compose exec app php artisan key:generate`
7. Run migrations: `docker-compose exec app php artisan migrate`
8. Seed database: `docker-compose exec app php artisan db:seed`
9. Clear cache: `docker-compose exec app php artisan optimize:clear`

### Local Development

1. Install dependencies: `composer install`
2. Copy `.env.example` to `.env`
3. Generate key: `php artisan key:generate`
4. Run migrations: `php artisan migrate`
5. Seed database: `php artisan db:seed`
6. Start Horizon: `php artisan horizon`

## Configuration

### Environment Variables

Copy `.env.example` to `.env` and configure your environment variables. See `.env.example` for all available options.

> ⚠️ **Security Note**: Never commit your `.env` file to version control. Always use `.env.example` as a template and keep your actual credentials secure.

## Multi-Language Setup

### Supported Languages
- Japanese (ja) - Main language
- English (en) - Fallback language
- Russian (ru) - Additional language

### Translation Files
- `resources/lang/{locale}/filament.php` - Filament-specific translations
- `resources/lang/{locale}/common.php` - Common translations

### Switching Language
1. Navigate to Settings → Language Settings (言語設定)
2. Select desired language
3. All pages and resources will update automatically

## CI/CD Pipeline

### GitHub Actions
- Automatic Docker image build on push to `main`
- Push to Docker Hub: `sherdev/trustflow-crm:latest`
- Workflow file: `.github/workflows/docker-build.yml`

## Database Schema

### Core Tables
- `tenants` - Multi-tenant configuration
- `users` - User accounts with roles
- `accounts` - Company/Account records
- `contacts` - Contact persons
- `leads` - Lead records with AI scores
- `deals` - Deal/opportunity records
- `projects` - Project records
- `tasks` - Task records
- `invoices` - Invoice records

### System Tables
- `roles` - User roles (Spatie Permission)
- `permissions` - Permissions (Spatie Permission)
- `model_has_roles` - Role assignments
- `media` - Media files (Spatie Media Library)
- `activity_log` - Activity logging (Spatie Activity Log)

## API Endpoints

### Web-to-Lead Form
- POST `/api/web-to-lead` - Submit lead from external form

### Admin Panel
- `/admin` - Filament admin panel
- `/admin/login` - Admin login

## Deployment

### Docker Hub
- Image: `sherdev/trustflow-crm:latest`
- Tag: `sherdev/trustflow-crm:v3.0`

### Production Checklist
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up Redis
- [ ] Configure AWS S3 (if using)
- [ ] Set OpenAI API key
- [ ] Run migrations
- [ ] Seed initial data
- [ ] Start Horizon workers
- [ ] Configure Nginx/Apache
- [ ] Set up SSL certificates

## Development

### Code Style
- Laravel Pint for code formatting
- PSR-12 coding standards

### Testing
- PHPUnit 11.0
- Feature and unit tests

### Debugging
- Laravel Telescope (optional)
- Activity Log for audit trail
- Horizon dashboard for queue monitoring

## Security

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

## Performance Optimization

### Implemented Optimizations

- **Redis Caching**: Default cache driver set to Redis
- **Queue Processing**: Laravel Horizon for background jobs
- **Database Indexing**: Comprehensive indexes on:
  - `tenant_id` columns (all tables)
  - `status` columns (frequently filtered)
  - Foreign keys (`account_id`, `contact_id`, `project_id`, etc.)
  - Composite indexes for common query patterns
- **Eager Loading**: All Resources use `with()` to prevent N+1 queries
  - Relationships loaded: `tenant`, `account`, `contact`, `project`, `deal`, `assignee`
- **Laravel Optimization**: 
  - Config caching: `php artisan config:cache`
  - Route caching: `php artisan route:cache`
  - View caching: `php artisan view:cache`
  - Application optimization: `php artisan optimize`

### Database Indexes

Indexes added to:
- `accounts`: tenant_id, status, (tenant_id, status)
- `contacts`: tenant_id, account_id, status, (tenant_id, account_id), (tenant_id, status)
- `leads`: tenant_id, status, source, (tenant_id, status), (tenant_id, source)
- `deals`: tenant_id, account_id, contact_id, stage, status, (tenant_id, account_id), (tenant_id, stage), (tenant_id, status)
- `projects`: tenant_id, deal_id, account_id, status, (tenant_id, account_id), (tenant_id, status)
- `tasks`: tenant_id, project_id, assigned_to, status, priority, (tenant_id, project_id), (tenant_id, status), (tenant_id, priority)
- `invoices`: tenant_id, project_id, account_id, status, (tenant_id, account_id), (tenant_id, status)
- `users`: tenant_id, role, (tenant_id, role)

## Monitoring

- System Health page for component status
- Horizon dashboard for queue monitoring
- Activity Log for user actions
- Error logging via Laravel Log

## Helper Classes

### DateHelper

Located at `app/Helpers/DateHelper.php`

Provides locale-aware date formatting:
- `getDateFormat()` - Returns format string based on locale
- `formatDate($date)` - Formats date according to locale
- `formatDateTime($datetime)` - Formats datetime with time
- `getDatePickerDisplayFormat()` - Format for Filament DatePicker display
- `getDatePickerFormat()` - Format for DatePicker storage (ISO: Y-m-d)

**Formats:**
- Japanese: `2025年12月29日` (date), `2025年12月29日 14:30` (datetime)
- English/Russian: `2025.12.29` (date), `2025.12.29 14:30` (datetime)

### TenantHelper

Located at `app/Helpers/TenantHelper.php`

Provides tenant management utilities:
- `getTenantId()` - Returns current user's tenant_id or creates default tenant (id=1)
- Ensures default tenant exists for Super Admin users

## System Architecture Diagram

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

## License

Proprietary
