FROM wordpress
COPY wp-content/themes wp-content/themes
COPY wp-content/plugins wp-content/plugins
VOLUME /var/www/html/wp-content/plugins
EXPOSE 80
