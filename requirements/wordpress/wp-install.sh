#!/bin/sh

wget https://wordpress.org/latest.tar.gz
tar -xzvf latest.tar.gz

mv wordpress/* /var/www/html/.
rm -rf wordpress latest.tar.gz
mv wp-config.php /var/www/html/.

wget http://www.adminer.org/latest.php -O adminer.php
chown -R www-data:www-data adminer.php
chmod 755 adminer.php
mv adminer.php /var/www/html/.
