FROM composer as vendor
COPY composer.json composer.json
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist
RUN mkdir -p /app/uploads

FROM wordpress
COPY --from=vendor --chown=www-data:www-data /app/vendor/wpackagist-plugin/ /var/www/html/wp-content/plugins/
COPY --from=vendor --chown=www-data:www-data /app/uploads /var/www/html/wp-content/uploads
COPY --chown=www-data:www-data . /var/www/html 
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY user.ini $PHP_INI_DIR/conf.d/

## Install S3 Fuse
FROM ubuntu:18.04
RUN apt-get update -y && \
    apt-get install -y build-essential libfuse-dev libcurl4-openssl-dev libxml2-dev pkg-config libssl-dev mime-support automake libtool wget tar git unzip
RUN apt-get install lsb-release -y  && apt-get install zip -y && apt-get install vim -y
RUN rm -rf /usr/src/s3fs-fuse
RUN git clone https://github.com/s3fs-fuse/s3fs-fuse/ /usr/src/s3fs-fuse
WORKDIR /usr/src/s3fs-fuse 
RUN ./autogen.sh && ./configure && make && make install

## Set Your AWS Access credentials
ARG AWS_ACCESS_KEY=$AWS_ACCESS_KEY
ENV AWS_ACCESS_KEY=$AWS_ACCESS_KEY
ARG AWS_SECRET_ACCESS_KEY=$AWS_ACCESS_KEY
ENV AWS_SECRET_ACCESS_KEY=$AWS_SECRET_ACCESS_KEY

## Set the directory where you want to mount your s3 bucket
ARG S3_MOUNT_DIRECTORY=/var/www/html/wp-content/uploads
ENV S3_MOUNT_DIRECTORY=$S3_MOUNT_DIRECTORY

## Replace with your s3 bucket name
ARG S3_BUCKET_NAME=$S3_BUCKET_NAME 
ENV S3_BUCKET_NAME=$S3_BUCKET_NAME 

## Mount S3 bucket and create automatic mount script
RUN echo $AWS_ACCESS_KEY:$AWS_SECRET_ACCESS_KEY > /root/.passwd-s3fs && \
    chmod 600 /root/.passwd-s3fs

## Entry Point
ADD start.sh /start.sh
RUN chmod 755 /start.sh 
CMD ["/start.sh"]

EXPOSE 80
