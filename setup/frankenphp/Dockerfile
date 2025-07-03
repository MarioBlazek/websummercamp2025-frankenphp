# syntax=docker/dockerfile:1

FROM dunglas/frankenphp

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY setup/frankenphp/Caddyfile /etc/caddy/Caddyfile
RUN install-php-extensions intl opcache pdo pdo_mysql zip


COPY . /app

RUN composer install

EXPOSE 80

