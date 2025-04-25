#!/bin/sh

/etc/init.d/mariadb start

while true; do
	/etc/init.d/mariadb status
	if [ $? -eq 0 ]; then
		break;
	fi
done

mariadb < init.sql

exec mariadbd
