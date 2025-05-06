#!/bin/sh

curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp-cli

wp-cli core download --allow-root
wp-cli plugin install redis-cache --activate --allow-root
wp-cli plugin update --all --allow-root

wget http://www.adminer.org/latest.php -O adminer.php
chown -R www-data:www-data adminer.php
chmod 755 adminer.php

