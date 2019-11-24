FROM composer as vendor
COPY composer.json composer.json
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

FROM wordpress
COPY wp-content/themes wp-content/themes
COPY --from=vendor /app/vendor/wpackagist-plugin/ /var/www/html/wp-content/plugins/
VOLUME /var/www/html/wp-content/uploads
EXPOSE 80
