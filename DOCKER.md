# Docker Setup Guide

## Prerequisites

- Docker & Docker Compose installed
- Make (optional, for convenience commands)

## Quick Start

```bash
# Complete setup (build, install dependencies, migrate, seed)
make setup

# Or manually:
make build
make up
make composer
make migrate
make seed
make install
```

## Access Application

- **Web**: http://localhost:8080
- **Admin Panel**: http://localhost:8080/admin
- **Database**: localhost:3306
- **Redis**: localhost:6379

## Default Credentials

- **Super Admin**: admin@trustflow.com / password
- **Demo Admin**: admin@demo.com / password

## Available Commands

```bash
make build      # Build Docker images
make up         # Start containers
make down       # Stop containers
make restart    # Restart containers
make shell      # Access app container shell
make composer   # Run composer install
make migrate    # Run migrations
make seed       # Seed database
make install    # Install Filament
make logs       # View logs
make test       # Run tests
```

## Environment Variables

Copy `.env.example` to `.env` and configure:

```env
DB_HOST=db
DB_DATABASE=trustflow_crm
DB_USERNAME=trustflow
DB_PASSWORD=root

REDIS_HOST=redis
REDIS_PORT=6379
```

## Troubleshooting

### Permission Issues
```bash
sudo chown -R $USER:$USER .
```

### Clear Cache
```bash
make shell
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Rebuild Containers
```bash
make down
docker-compose build --no-cache
make up
```

