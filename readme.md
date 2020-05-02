## Start up

```
composer install
ln -s /full/source/path/wp-content /full/link/path/wordpress
```

Valet link composer generated wordpress directory

`cd wordpress`
`valet link`

## Docker

`docker volume create thefcfweb-wp`

`docker run -p 8080:80 --env-file .env -v thefcfweb-wp:/var/www/html thefcfweb`
