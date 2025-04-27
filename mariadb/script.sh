#!/bin/bash

mariadbd-safe

while true; do
	service mariadb status
	if [ $? -eq 0 ]; then
		break;
	fi
done

mariadb << EOF
CREATE DATABASE IF NOT EXISTS wp_site;
CREATE USER IF NOT EXISTS 'jburlama'@'%' IDENTIFIED BY '${PASSWD}';
GRANT ALL PRIVILEGES ON wp_site.* TO 'jburlama'@'%' IDENTIFIED BY '${PASSWD}';
FLUSH PRIVILEGES;
EOF

exec mariadb

