FROM composer:lts AS composer


FROM node:23-alpine AS builder
COPY . /build
RUN apk add --no-cache \
    python3 \
    make \
    g++ \
    && rm -rf /var/cache/apk/* \
    && yarn global add node-gyp

WORKDIR /build
RUN yarn install \
    && yarn dev


FROM php:8.3-fpm-alpine

ENV APP_ENV=dev

RUN apk add --no-cache --virtual .build-dependencies ${PHPIZE_DEPS} \
    && apk add --no-cache linux-headers \
    && apk add --no-cache php-intl icu-dev zlib-dev zip libzip-dev \
    && pecl install apcu \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && apk del .build-dependencies \
	&& docker-php-ext-configure intl \
	&& docker-php-ext-install intl mysqli pdo pdo_mysql opcache zip \
	&& docker-php-ext-enable apcu intl mysqli pdo pdo_mysql opcache xdebug zip


COPY --from=builder /build /build
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY .github/workflows/manifests/php/conf/*.ini /usr/local/etc/php/conf.d/
COPY .github/workflows/manifests/php/conf/www.* /usr/local/etc/php-fpm.d/

WORKDIR /build
RUN mkdir -p var/cache \
    && mkdir -p var/uploads \
    && mkdir -p var/log \
	&& composer install\
    && chown -R www-data:www-data /build

CMD ["sh", "-c", "cd /build \
    && php bin/console doctrine:database:create --if-not-exists --no-interaction \
    && php bin/console doctrine:migrations:migrate --no-interaction \
    && php-fpm"]
