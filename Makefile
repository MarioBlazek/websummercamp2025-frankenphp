.PHONY: install up down build cs phpstan clear cache dev

# Install PHP and JS dependencies
install:
	docker compose exec php composer install

build:
	docker compose build

# Start Docker containers (if you use Docker)
up:
	docker compose up -d

# Stop Docker containers
down:
	docker compose down

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
	docker compose exec app bash

