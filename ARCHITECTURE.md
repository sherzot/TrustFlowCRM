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
│   │   ├── Pages/          # Custom pages (Kanban, OKR, Health)
│   │   └── Widgets/        # Dashboard widgets
│   ├── Models/             # Eloquent models
│   ├── Services/           # AI services
│   ├── Observers/          # Model observers
│   ├── Jobs/               # Background jobs
│   └── Policies/           # Authorization policies
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
└── config/                 # Configuration files
```

## Key Features

### 1. Multi-Tenant Architecture
- Each agency has isolated workspace
- Tenant-based data segregation
- Custom domains support

### 2. AI-Powered Features
- **Lead Scoring**: Automatic lead quality scoring
- **Deal Prediction**: Success probability prediction
- **Email Generation**: AI-generated email content
- **NLP**: Natural language question answering
- **Risk Detection**: Deal risk analysis

### 3. Sales Pipeline
- Lead → Account → Contact → Deal → Project → Invoice
- Full history tracking
- AI scoring at each stage
- Kanban board visualization

### 4. Project Management
- Time tracking
- Task management
- Progress tracking
- Profit calculation

### 5. Finance Management
- Multi-currency support
- Automatic invoicing
- Profit & ROI tracking
- Payment tracking

### 6. Analytics & Reporting
- Sales funnel visualization
- Profit charts
- OKR dashboard
- AI insights

### 7. Integrations
- Telegram notifications
- WhatsApp messaging
- Jira integration
- Xero accounting sync
- Email inbound processing

## Technology Stack

- **Backend**: Laravel 10
- **Admin Panel**: Filament 3
- **Database**: MySQL + Redis
- **Queue**: Laravel Horizon
- **Storage**: AWS S3 / MinIO
- **AI**: OpenAI GPT-4
- **Multi-tenancy**: Stancl Tenancy

## User Roles

1. **Super Admin**: Platform owner, manages tenants
2. **Agency Admin**: Manages agency settings, OKRs
3. **Sales Team**: Handles leads, deals, proposals
4. **Delivery Team**: Manages projects, tasks, time tracking
5. **Finance Team**: Manages invoices, costs, profit
6. **Client**: Access to client portal

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

1. Install dependencies: `composer install`
2. Copy `.env.example` to `.env`
3. Generate key: `php artisan key:generate`
4. Run migrations: `php artisan migrate`
5. Seed database: `php artisan db:seed`
6. Install Filament: `php artisan filament:install --panels`
7. Start Horizon: `php artisan horizon`

## Configuration

Set up environment variables in `.env`:
- Database credentials
- OpenAI API key
- Telegram/WhatsApp tokens
- AWS S3 credentials
- Jira/Xero credentials

