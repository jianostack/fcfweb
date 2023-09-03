# Fisherman of Christ website

Come visit us at fcf.org.sg

And He said to them, Follow Me, and I will make you fishers of men – Matthew 4:19

Containerised Wordpress uploading to AWS S3.

To God be the glory!

## Localhost

```
brew install wp-cli
composer install
wp core download --skip-content
cp wp-config-sample.php wp-config.php
wp server
```

## W3 Total Cache Plugin

To purge the CSS files in the theme you will need to:
1. Go to CDN > General > Upload theme files 
2. Go to Azure Endpoints and purge the CDN cache
