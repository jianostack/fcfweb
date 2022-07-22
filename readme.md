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
wp theme install twentytwentyone
cp wp-config-sample.php wp-config.php
```

## S3-upload plugin

> If you want to create your IAM user yourself, or attach the necessary permissions to an existing user, you can output the policy via `wp s3-uploads generate-iam-policy`

https://github.com/humanmade/S3-Uploads
