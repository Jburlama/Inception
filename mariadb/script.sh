#!/bin/sh

mariadbd-safe

while true; do
	service mariadb status
	if [ $? -eq 0 ]; then
		break;
	fi
done

mariadb < init.sql

exec mariadb
