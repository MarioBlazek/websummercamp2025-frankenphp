# syntax=docker/dockerfile:1

FROM dunglas/frankenphp

ENV SERVER_NAME=:80

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY setup/frankenphp/Caddyfile /etc/caddy/Caddyfile
RUN install-php-extensions intl opcache pdo pdo_mysql zip


COPY . /app

RUN composer install

EXPOSE 80

