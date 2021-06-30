# Fisherman of Christ website

Containerised Wordpress uploading to AWS S3.

## Localhost

```
brew install wp-cli
composer install
wp core download --skip-content
wp theme install twentytwentyone
cp wp-config-sample.php wp-config.php
```

## S3-upload plugin

https://github.com/humanmade/S3-Uploads#install-using-composer

