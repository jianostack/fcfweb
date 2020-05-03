FROM composer as vendor
COPY composer.json .
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist
RUN mkdir -p /app/uploads   

FROM wordpress
COPY --from=vendor --chown=www-data:www-data /app/vendor/wpackagist-plugin/ /var/www/html/wp-content/plugins/
COPY --from=vendor --chown=www-data:www-data /app/vendor/humanmade/ /var/www/html/wp-content/plugins/
COPY --from=vendor --chown=www-data:www-data /app/uploads /var/www/html/wp-content/uploads
COPY --chown=www-data:www-data . /var/www/html 
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY user.ini $PHP_INI_DIR/conf.d/

EXPOSE 80
