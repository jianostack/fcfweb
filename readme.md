## Development

`composer install`

`npm i`

`gulp`

### WP multisite

In wp-config.php before DB configs:

```
define('WP_SITEURL', '//' . $_SERVER['SERVER_NAME'] );
define('WP_HOME',    '//' . $_SERVER['SERVER_NAME'] );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', '127.0.0.1:8000');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
```

## Distribution

`gulp dist`
