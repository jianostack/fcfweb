#! /bin/bash

composer install
mv wp-content tmp-wp-content
mv composer.json tmp-composer.json
mv wp-config.php tmp-wp-config.php
cp -a wordpress/. .
rm -rf wp-content
mv tmp-wp-content wp-content
mv tmp-composer.json composer.json
mv tmp-wp-config.php wp-config.php
