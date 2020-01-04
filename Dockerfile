FROM composer as vendor
COPY composer.json composer.json
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

FROM wordpress
COPY --from=vendor --chown=www-data:www-data /app/vendor/wpackagist-plugin/ /var/www/html/wp-content/plugins/
COPY --chown=www-data:www-data . /var/www/html 
RUN mkdir -p /var/www/html/wp-content/uploads
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY user.ini $PHP_INI_DIR/conf.d/
EXPOSE 80
