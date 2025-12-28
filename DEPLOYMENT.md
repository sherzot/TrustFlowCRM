# Deployment Guide

## GitHub Repository Setup

1. **Create Repository on GitHub**
   - Go to https://github.com/sherzot
   - Click "New repository"
   - Name: `TrustFlowCRM`
   - Set as Public or Private
   - Don't initialize with README (we already have one)

2. **Push Code to GitHub**
   ```bash
   git init
   git add .
   git commit -m "Initial commit: TrustFlow CRM v3.0 Enterprise B2B Growth Engine"
   git branch -M main
   git remote add origin https://github.com/sherzot/TrustFlowCRM.git
   git push -u origin main
   ```

## Docker Hub Deployment

### Build and Push Image

1. **Login to Docker Hub**
   ```bash
   docker login
   # Username: sherdev
   ```

2. **Build Image**
   ```bash
   docker build -t sherdev/trustflow-crm:latest .
   ```

3. **Tag Image**
   ```bash
   docker tag trustflow-crm:latest sherdev/trustflow-crm:latest
   docker tag trustflow-crm:latest sherdev/trustflow-crm:v3.0
   ```

4. **Push to Docker Hub**
   ```bash
   docker push sherdev/trustflow-crm:latest
   docker push sherdev/trustflow-crm:v3.0
   ```

### Pull and Run from Docker Hub

```bash
# Pull image
docker pull sherdev/trustflow-crm:latest

# Run with docker-compose
docker-compose up -d
```

## Local Docker Setup

### Quick Start

```bash
# Complete setup
make setup

# Or step by step:
make build
make up
make composer
make migrate
make seed
make install
```

### Access Application

- **Web**: http://localhost:8080
- **Admin**: http://localhost:8080/admin
- **Database**: localhost:3306
- **Redis**: localhost:6379

### Default Credentials

- **Super Admin**: admin@trustflow.com / password
- **Demo Admin**: admin@demo.com / password

## Environment Configuration

Copy `.env.example` to `.env` and configure:

```env
APP_NAME="TrustFlow CRM"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=trustflow_crm
DB_USERNAME=trustflow
DB_PASSWORD=root

REDIS_HOST=redis
REDIS_PORT=6379

OPENAI_API_KEY=your_openai_key_here
TELEGRAM_BOT_TOKEN=your_telegram_token
WHATSAPP_API_KEY=your_whatsapp_key
```

## Production Deployment

### Using Docker Compose

1. **Update docker-compose.yml** for production:
   - Set environment variables
   - Configure volumes for persistent storage
   - Set up SSL/TLS

2. **Deploy**:
   ```bash
   docker-compose -f docker-compose.prod.yml up -d
   ```

### Using Docker Hub Image

```bash
docker run -d \
  --name trustflow-crm \
  -p 8080:80 \
  -e DB_HOST=your_db_host \
  -e DB_DATABASE=trustflow_crm \
  -e DB_USERNAME=your_db_user \
  -e DB_PASSWORD=your_db_password \
  sherdev/trustflow-crm:latest
```

## Troubleshooting

### Permission Issues
```bash
sudo chown -R $USER:$USER .
```

### Clear Cache
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
```

### View Logs
```bash
docker-compose logs -f app
docker-compose logs -f nginx
```

### Rebuild
```bash
make down
docker-compose build --no-cache
make up
```

