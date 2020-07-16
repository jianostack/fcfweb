# Fisherman of Christ website

Containerised Wordpress uploading to AWS S3.

## Localhost

```
brew install wp-cli
composer global require laravel/valet
composer install
wp core download --skip-content
cp wp-config-sample.php wp-config.php
valet open
```

## S3-upload plugin

https://github.com/humanmade/S3-Uploads#install-using-composer

