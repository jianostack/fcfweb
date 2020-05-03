FROM composer as vendor
COPY composer.json composer.json
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist
RUN mkdir -p /app/uploads   



# Add crontab file in the cron directory
ADD crontab /etc/cron.d/hello-cron
# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/hello-cron
# Create the log file to be able to run tail
RUN touch /var/log/cron.log
#Install Cron
RUN apt-get update
RUN apt-get -y install cron
# Run the command on container startup
CMD cron && tail -f /var/log/cron.log

FROM wordpress
COPY --from=vendor --chown=www-data:www-data /app/vendor/wpackagist-plugin/ /var/www/html/wp-content/plugins/
COPY --from=vendor --chown=www-data:www-data /app/uploads /var/www/html/wp-content/uploads
COPY --chown=www-data:www-data . /var/www/html 
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY user.ini $PHP_INI_DIR/conf.d/

EXPOSE 80
