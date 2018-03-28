#! /bin/bash

mv wp-content/ temp/
mv composer.json temp-composer.json
cp -a wordpress/. .
rm -rf wp-content
mv temp/ wp-content/
rm -rf wordpress/
mv wp-config-sample.php wp-config.php
mv temp-composer.json composer.json