FROM composer:latest AS composer

FROM php:7.4-fpm-alpine

ENV APP_ENV=dev

RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
    && apk add --update --no-cache php-intl icu-dev zlib-dev zip libzip-dev \
    && apk add yarn\
    && pecl install apcu \
    && pecl install xdebug \
    && apk del .build-dependencies \
	&& docker-php-ext-configure intl \
	&& docker-php-ext-install intl mysqli pdo pdo_mysql opcache zip \
	&& docker-php-ext-enable apcu intl mysqli pdo pdo_mysql opcache xdebug zip

COPY . /build
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY .github/workflows/manifests/development/php/conf/*.ini /usr/local/etc/php/conf.d/
COPY .github/workflows/manifests/development/php/conf/www.* /usr/local/etc/php-fpm.d/

RUN cd /build \
    && mkdir -p var/cache \
    && mkdir -p var/flysystem \
    && mkdir -p var/log \
	&& composer install\
	&& yarn install \
 	&& yarn dev \
    && chown -R www-data:www-data /build

CMD cd /build \
    && php bin/console doctrine:database:create --if-not-exists --no-interaction \
    && php bin/console doctrine:migrations:migrate --no-interaction \
    && php-fpm
