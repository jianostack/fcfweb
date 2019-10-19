FROM wordpress
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY composer.json .
RUN composer install
COPY wp-content/themes/ wp-content/themes/ 
EXPOSE 80
