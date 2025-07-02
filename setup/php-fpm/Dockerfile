FROM php:8.4-fpm-bullseye

USER root

RUN apt-get update \
  && apt-get upgrade -y \
  && apt-get install -y wget vim libpng-dev libfreetype6-dev libjpeg62-turbo-dev zlib1g-dev g++ libicu-dev zip libzip-dev zip \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN docker-php-ext-install intl opcache pdo pdo_mysql zip
RUN pecl install redis && docker-php-ext-enable redis

# hack to fix www-data not being able to write to the mounted volume
ARG OS_TYPE
ARG www_data_uid
ARG www_data_gid

COPY --from=composer /usr/bin/composer /usr/bin/composer

#COPY ini/custom.ini /usr/local/etc/php/conf.d/

RUN echo $OS_TYPE > /var/www/os_type
RUN echo $www_data_uid >> /var/www/os_type
RUN echo $www_data_gid >> /var/www/os_type

RUN mkdir /var/www/.composer
RUN chown -R www-data:www-data /var/www/.composer

RUN if [ "$OS_TYPE" = "Linux" ]; then \
    	groupmod -g $www_data_gid www-data; \
    	usermod -u $www_data_uid -g $www_data_gid www-data; \
    	chown -R www-data. /var/www; \
    else \
    	echo "Not Linux, skipping.."; \
    fi

USER www-data

WORKDIR /var/www/franken

EXPOSE 9000
