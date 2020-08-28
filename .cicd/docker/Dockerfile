FROM ricc/composer-prestissimo as composer
FROM php:7.4-cli

WORKDIR /var/www

ARG DEV

# Run composer from builder image
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=composer /tmp /root/.composer

COPY . ./

RUN if [ "$DEV" = true ] ; \
    then pecl install xdebug \
        && docker-php-ext-enable xdebug; \
    fi

RUN if [ "$DEV" = true ] ; \
    then composer install; \
    else composer install --no-dev --no-scripts --prefer-dist --no-progress --no-autoloader \
      && composer dump-autoload --optimize; \
    fi

ENTRYPOINT [""]