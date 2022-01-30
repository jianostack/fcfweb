FROM composer as composer
COPY composer.json composer.lock .
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist
WORKDIR /app/vendor/humanmade/s3-uploads
RUN composer install
RUN mkdir -p /app/uploads   

FROM wordpress:php8.0
COPY --from=composer --chown=www-data:www-data /app/vendor/wpackagist-plugin/ /var/www/html/wp-content/plugins/
COPY --from=composer --chown=www-data:www-data /app/vendor/humanmade/ /var/www/html/wp-content/plugins/
COPY --from=composer --chown=www-data:www-data /app/uploads /var/www/html/wp-content/uploads
COPY --chown=www-data:www-data . /var/www/html 
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY user.ini $PHP_INI_DIR/conf.d/

EXPOSE 80
