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
- **AI-Powered** - Lead scoring, deal prediction, email generation, NLP
- **Sales Pipeline** - Complete lead to deal conversion tracking
- **Project Management** - Time tracking, tasks, Kanban boards
- **Finance Management** - Invoicing, multi-currency, profit tracking
- **Analytics & Reporting** - Sales funnel, profit charts, OKR dashboard
- **System Health Monitoring** - Real-time system component status

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

Edit `.env` file with your configuration:

```env
# Application
APP_NAME="TrustFlow CRM"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080
APP_LOCALE=ja
APP_FALLBACK_LOCALE=en

# Database
DB_CONNECTION=mysql
DB_HOST=db  # Use 'localhost' for local setup
DB_PORT=3306
DB_DATABASE=trustflow_crm
DB_USERNAME=trustflow
DB_PASSWORD=root

# Redis
REDIS_HOST=redis  # Use '127.0.0.1' for local setup
REDIS_PASSWORD=null
REDIS_PORT=6379

# Queue
QUEUE_CONNECTION=redis

# OpenAI (for AI features)
OPENAI_API_KEY=your_openai_api_key_here

# AWS S3 (optional, for file storage)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
```

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

## 👥 Default Users

After seeding, you can log in with:

- **Super Admin**: `admin@trustflow.com` / `password`
- **Demo Admin**: `admin@demo.com` / `password`

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

# Access MySQL
docker-compose exec db mysql -u trustflow -proot trustflow_crm

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

## 📊 Monitoring

- **System Health Page** - Monitor database, cache, queue, storage
- **Horizon Dashboard** - Queue monitoring at `/admin/horizon`
- **Activity Log** - User action tracking
- **Error Logging** - Laravel log files

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
