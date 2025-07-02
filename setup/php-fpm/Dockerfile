# syntax=docker/dockerfile:1

FROM php:8.4-fpm-bullseye AS app

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY setup/php-fpm/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN install-php-extensions intl opcache pdo pdo_mysql zip

WORKDIR /var/www/franken

COPY . .

RUN composer install

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

EXPOSE 9000

CMD ["php-fpm"]
