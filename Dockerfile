FROM php:7.3-apache-stretch
COPY user.ini $PHP_INI_DIR/conf.d/
RUN a2enmod rewrite
COPY ./app /var/www/html
WORKDIR /var/www/html
RUN mkdir public
RUN chmod -R 0775 public
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN chown -R www-data:www-data /var/www/html
EXPOSE 80




COPY wp-content/themes wp-content/themes
COPY wp-content/plugins wp-content/plugins
VOLUME /var/www/html/wp-content/uploads
RUN chown -R www-data:www-data /var/www/html/wp-content
