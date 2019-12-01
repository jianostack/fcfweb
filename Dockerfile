FROM composer as vendor
COPY composer.json composer.json
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

FROM wordpress
COPY --from=vendor /app/vendor/wpackagist-plugin/ /var/www/html/wp-content/plugins/
COPY --chown=www-data:www-data . /var/www/html/ 
VOLUME /var/www/html
EXPOSE 80
