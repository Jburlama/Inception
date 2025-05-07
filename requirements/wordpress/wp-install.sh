#!/bin/sh

curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp

wp core download --allow-root
wp plugin install redis-cache --activate --allow-root
wp redis enable --force --allow-root

wget http://www.adminer.org/latest.php -O adminer.php
chown -R www-data:www-data adminer.php
chmod 755 adminer.php

