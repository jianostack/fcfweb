FROM composer as composer
COPY composer.json composer.lock /app/
RUN composer install
RUN mkdir -p /app/uploads

FROM wordpress:php8.0
COPY --from=composer --chown=www-data:www-data /app/wp-content/plugins /var/www/html/wp-content/plugins
COPY --from=composer --chown=www-data:www-data /app/uploads /var/www/html/wp-content/uploads
COPY --chown=www-data:www-data wp-content/themes/twentytwenty-child /var/www/html/wp-content/themes/twentytwenty-child
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY user.ini $PHP_INI_DIR/conf.d/
EXPOSE 80
