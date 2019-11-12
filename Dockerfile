FROM wordpress
COPY wp-content/themes wp-content/themes
COPY wp-content/plugins wp-content/plugins
VOLUME /var/www/html/wp-content/uploads
RUN chown -R www-data:www-data /var/www/html/wp-content
EXPOSE 80
