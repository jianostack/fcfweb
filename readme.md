# Fisherman of Christ website

And He said to them, Follow Me, and I will make you fishers of men – Matthew 4:19

To God be the glory!

## Localhost

```
brew install wp-cli
composer install
wp core download --skip-content
cp wp-config-sample.php wp-config.php
wp server
```

## Gotchas

Composer install will fail when local PHP version is not the same as in composer.lock
- Use the install.sh
