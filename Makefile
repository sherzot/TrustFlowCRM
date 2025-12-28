.PHONY: help build up down restart shell composer migrate seed install test

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Available targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build Docker images
	docker-compose build

up: ## Start containers
	docker-compose up -d

down: ## Stop containers
	docker-compose down

restart: ## Restart containers
	docker-compose restart

shell: ## Access app container shell
	docker-compose exec app bash

composer: ## Run composer install
	docker-compose exec app composer install

migrate: ## Run database migrations
	docker-compose exec app php artisan migrate

seed: ## Seed database
	docker-compose exec app php artisan db:seed

install: ## Install Filament panels
	docker-compose exec app php artisan filament:install --panels

setup: build up composer migrate seed install ## Complete setup (build, install, migrate, seed)
	@echo "Setup complete! Access the application at http://localhost:8080"

logs: ## View logs
	docker-compose logs -f app

test: ## Run tests
	docker-compose exec app php artisan test

