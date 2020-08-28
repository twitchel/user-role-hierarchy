FROM ricc/composer-prestissimo as composer
FROM php:7.4-cli-alpine

WORKDIR /var/www

ENV COMPOSER_ALLOW_SUPERUSER 1
ARG DEV

# Run composer from builder image
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=composer /tmp /root/.composer
COPY composer.json composer.lock ./

RUN if [ "$DEV" = true ] ; \
    then apk add --no-cache --update \
        $PHPIZE_DEPS \
        git \
        libzip-dev \
        && pecl install xdebug \
        && docker-php-ext-enable xdebug; \
    fi

RUN if [ "$DEV" = true ] ; \
    then composer install; \
    else composer install --no-dev --no-scripts --prefer-dist --no-progress --no-autoloader \
      && composer dump-autoload --optimize; \
    fi

COPY . ./

ENTRYPOINT [""]