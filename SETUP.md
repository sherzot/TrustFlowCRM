# Setup Guide

## Prerequisites

- Docker & Docker Compose
- Git
- Make (optional)

## Step-by-Step Setup

### 1. Clone Repository

```bash
git clone https://github.com/sherzot/TrustFlowCRM.git
cd TrustFlowCRM
```

### 2. Environment Configuration

```bash
cp .env.example .env
```

Edit `.env` file:
```env
DB_HOST=db
DB_DATABASE=trustflow_crm
DB_USERNAME=trustflow
DB_PASSWORD=root

REDIS_HOST=redis
REDIS_PORT=6379
```

### 3. Docker Setup

```bash
# Build and start containers
make setup

# Or manually:
make build
make up
```

### 4. Install Dependencies

```bash
make composer
# Or: docker-compose exec app composer install
```

### 5. Generate Application Key

```bash
docker-compose exec app php artisan key:generate
```

### 6. Run Migrations

```bash
make migrate
# Or: docker-compose exec app php artisan migrate
```

### 7. Seed Database

```bash
make seed
# Or: docker-compose exec app php artisan db:seed
```

### 8. Install Filament

```bash
make install
# Or: docker-compose exec app php artisan filament:install --panels
```

### 9. Access Application

- **Web**: http://localhost:8080
- **Admin Panel**: http://localhost:8080/admin

### 10. Login Credentials

- **Super Admin**: admin@trustflow.com / password
- **Demo Admin**: admin@demo.com / password

## Quick Commands

```bash
make setup      # Complete setup
make up         # Start containers
make down       # Stop containers
make shell      # Access container shell
make logs       # View logs
make test       # Run tests
```

## Troubleshooting

### Port Already in Use

Change port in `docker-compose.yml`:
```yaml
ports:
  - "8081:80"  # Change 8080 to 8081
```

### Permission Denied

```bash
sudo chown -R $USER:$USER .
```

### Database Connection Error

Check if database container is running:
```bash
docker-compose ps
docker-compose logs db
```

### Clear Cache

```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
```

