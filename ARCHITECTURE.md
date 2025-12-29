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

## User Roles

1. **Super Admin**: Platform owner, manages tenants (no tenant_id)
2. **Agency Admin**: Manages agency settings, OKRs
3. **Sales Team**: Handles leads, deals, proposals
4. **Delivery Team**: Manages projects, tasks, time tracking
5. **Finance Team**: Manages invoices, costs, profit
6. **Client**: Access to client portal

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

### Environment Variables (.env)

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

## Performance

- Redis caching
- Queue processing via Horizon
- Database indexing
- Eager loading relationships
- Image optimization

## Monitoring

- System Health page for component status
- Horizon dashboard for queue monitoring
- Activity Log for user actions
- Error logging via Laravel Log

## License

Proprietary
