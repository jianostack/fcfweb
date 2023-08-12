FROM composer as composer
COPY composer.json composer.lock /app/
RUN composer install --no-scripts --no-interaction --no-dev --prefer-dist
FROM wordpress:php8.2
COPY --from=composer --chown=www-data:www-data /app /var/www/html
COPY --chown=www-data:www-data wp-content/plugins/fcf-worship-registration /var/www/html/wp-content/plugins/fcf-worship-registration
COPY --chown=www-data:www-data wp-content/themes/twentytwenty-child /var/www/html/wp-content/themes/twentytwenty-child
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY user.ini $PHP_INI_DIR/conf.d/
EXPOSE 80
