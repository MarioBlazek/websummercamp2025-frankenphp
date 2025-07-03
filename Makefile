.PHONY: install up down build cs phpstan clear cache dev

# Install PHP and JS dependencies
install:
	docker compose exec app composer install

build:
	cp setup/.env.dev.local.template .env.dev.local
	docker compose build

# Start Docker containers (if you use Docker)
up:
	docker compose up -d

# Stop Docker containers
down:
	docker compose down

enter-app:
	docker compose exec app /bin/bash

# Run PHP-CS-Fixer
cs:
	vendor/bin/php-cs-fixer fix --allow-risky=yes

# Run PHPStan
phpstan:
	vendor/bin/phpstan analyse src --level=max

# Clear Symfony cache
clear:
	php bin/console cache:clear

bash:
	docker compose exec franken bash

db:
	docker compose exec app php bin/console doctrine:database:drop --force
	docker compose exec app php bin/console doctrine:database:create --if-not-exists
	docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction
	docker compose exec app php bin/console app:init-polls

consume:
	docker compose exec app php bin/console messenger:consume async

logs-consumer:
	docker logs franken_app_worker
