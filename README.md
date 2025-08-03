### This project aims to broaden my knowledge of system administration through the use of Docker. This project involves setting up a small infrastructure composed of different services under specific rules

- The whole project has to be done in a virtual machine. Docker Compose must be used.
- Each service has to run in a dedicated container.
- For performance reasons, the containers must be built from either the penultimate stable version of Alpine or Debian
- One Dockerfile must be written per service. We have to build the Docker images.
- The Dockerfiles must be called in docker-compose.yml by the Makefile.
- It is then forbidden to pull ready-made Docker images or use services such as DockerHub (Alpine/Debian being excluded from this rule).


### I have to set up:

• A Docker container that contains NGINX with TLSv1.2 or TLSv1.3 only.

• A Docker container that contains WordPress with php-fpm (it must be installed
and configured) only, without nginx

• A Docker container that contains only MariaDB, without nginx.

• A volume that contains the WordPress database.

• A second volume that contains your WordPress website files.

• A docker-network that establishes the connection between your containers.

• The containers must restart automatically in case of a crash.

#### Bonus list

• Set up redis cache for your WordPress website in order to properly manage the cache.

• Set up a FTP server container pointing to the volume of your WordPress website.

• Create a simple static website in the language of your choice except PHP

• Set up Adminer.

• Set up a service of your choice that you think is useful. (cadvisor)



# Docker-compse.yml

Docker compose is a tool that lets you run and manage multiple Docker containers together using a single configuration file.
For a list of docker compose commands run `docker compose --help`

```docker-compose.yml
services:
 nginx:
  build: ./requirements/nginx/
  image: nginx:42
  container_name: nginx
  restart: on-failure
  ports:
   - "443:443"
  volumes:
   - wordpress:/var/www/html        
  networks:
   - inception
  env_file:
    - .env

 wordpress:
  build: ./requirements/wordpress/
  image: wordpress:42
  container_name: wordpress
  restart: on-failure
  expose:
   - "9000"
  depends_on:
   - mariadb
  volumes:
   - wordpress:/var/www/html
  networks:
   - inception
  env_file:
    - .env

 mariadb:
  build: ./requirements/mariadb/
  image: mariadb:42
  container_name: mariadb
  restart: on-failure
  expose:
   - "3306"
  networks:
   - inception
  depends_on:
   - nginx
  volumes:
   - mariadb:/var/lib/mysql
  env_file:
    - .env

 redis:
  build: ./requirements/redis/
  image: redis:42
  container_name: redis
  restart: on-failure
  ports:
   - "6379:6379"
  expose:
   - "6379"
  depends_on:
   - mariadb
  networks:
   - inception
  volumes:
   - redis:/var/lib/redis
  env_file:
    - .env

 ftp:
  build: ./requirements/ftp/
  image: ftp:42
  container_name: ftp
  restart: on-failure
  ports:
    - "20:20"
    - "21:21"
    - "40000-40005:40000-40005"
  depends_on:
   - wordpress
  networks:
   - inception
  volumes:
    - wordpress:/home/jburlama/ftp/files
  env_file:
    - .env

 cadvisor:
  container_name: cadvisor
  build: ./requirements/cadvisor/.
  image: cadvisor:42
  restart: on-failure
  ports:
   - "8080:8080"
  networks:
   - inception
  volumes:
    - /:/rootfs:ro
    - /var/run:/var/run:ro 
    - /sys:/sys:ro 
    - /var/lib/docker/:/var/lib/docker:ro

networks:
 inception:
   driver: bridge

volumes:
  wordpress:
    driver_opts:
      type: none
      device: /home/jburlama/data/wordpress
      o: bind
  mariadb:
    driver_opts:
      type: none
      device: /home/jburlama/data/mariadb
      o: bind
  redis:
    driver_opts:
      type: none
      device: /home/jburlama/data/redis
      o: bind
```


# Nginx

NGINX is a web server and reverse proxy that helps deliver web content quickly and efficiently.

```Dockerfile
FROM debian:bullseye

RUN apt update && apt upgrade -y && apt install nginx openssl -y \
	&& mkdir -p /etc/nginx/ssl \
	&& openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
		-keyout /etc/nginx/ssl/private.key \
		-out /etc/nginx/ssl/certificate.crt \
		-subj "/CN=nginx" \
	&& chmod 600 /etc/nginx/ssl/private.key \
	&& chmod 644 /etc/nginx/ssl/certificate.crt

COPY default.conf /etc/nginx/conf.d/.

ENTRYPOINT ["nginx", "-g", "daemon off;"]
```

```default.conf
server {
	listen 443 ssl default_server;

	ssl_certificate /etc/nginx/ssl/certificate.crt;
	ssl_certificate_key /etc/nginx/ssl/private.key;

	root /var/www/html;
	index index.php index.html index.html;

	server_name nginx;

	location / {
		try_files $uri $uri/ =404;
	}

	location ~ \.php$ {
		include snippets/fastcgi-php.conf;
		fastcgi_pass wordpress:9000;
	}

	location ~ /\.ht {
		deny all;
	}
}
```

# Wordpress

WordPress is a free platform for creating websites and blogs
PHP-FPM (FastCGI Process Manager) is a tool that helps your web server (like Nginx) run PHP code more efficiently. 

```Dockerfile
FROM debian:bullseye

WORKDIR app/

RUN apt update && apt upgrade -y \
	&& apt install wget php7.4-fpm php7.4-mysqli php7.4-redis curl -y \
	&& mkdir -p /run/php

RUN mkdir -p /run/php && chown -R www-data:www-data /run/php
RUN mkdir -p /var/www/html

COPY www.conf /etc/php/7.4/fpm/pool.d/.
COPY wp-config.php .
COPY wp-install.sh .

RUN chmod +x wp-install.sh
RUN ./wp-install.sh
RUN rm wp-install.sh
RUN mv * /var/www/html

RUN chown -R www-data:www-data /var/www/html/wp-content
RUN chmod -R 775 /var/www/html/wp-content

ENTRYPOINT ["/usr/sbin/php-fpm7.4", "-F"]
```

```wp-confg.php
<?php

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_site' );

/** Database username */
define( 'DB_USER', 'jburlama' );

/** Database password */
define( 'DB_PASSWORD', getenv('PASSWD') );

/** Database hostname */
define( 'DB_HOST', 'mariadb' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'WP_REDIS_HOST', 'redis' );
define( 'WP_REDIS_PORT', 6379 );     

// Force Redis cache drop-in
define('WP_REDIS_DISABLED', false);
define('WP_REDIS_IGNORE_GLOBAL_GROUPS', true);

define('WP_CACHE', true);

/**#@+
 * Authentication unique keys and salts.
 */
define('AUTH_KEY',         'zh;|yVI;%>*XTBx@S|N|2pd++h^{<S9s6GrHAP(d0Z>G-bzmeGpT}%& OQn=mWRU');
define('SECURE_AUTH_KEY',  'nk-(6~gr1t/g/F%~&7^^+o^N^qx70|tl:`PFUwMQJbq mE/t4-8K</{#BO$,=qNC');
define('LOGGED_IN_KEY',    ') JPuau*GjuU6H5_t}f;`;H0=3:OLFBU-.ful~(.aItVGP1dR!s3N6wC`leLN:0q');
define('NONCE_KEY',        '`H[9x4JK#>q$EVQ|e+G1G)Y{^fx/E[hZi+E&WX3Pr<R.3:R aZU7YFkY K>|9`g(');
define('AUTH_SALT',        '4U}?{(6l-7`xv=[jO. e9sm]`VDt6RN!akWL0#X,TL<I&Wvgz-h$}-Sqd7+f:gWi');
define('SECURE_AUTH_SALT', '*rIZ}$L8 .M$20[9pW,>* Ijs`#1zKNy<cG-1J>yrU|?r|pyYm2*yQL}y~;>&|^j');
define('LOGGED_IN_SALT',   'GuS,wFfx_D20|a*Pg9r8leEoZ^x-0/6E:j%I4`S)n(Y2e2oe+;+DURj0syFy|d[u');
define('NONCE_SALT',       'jbaU,@kEX{vn~gP08=xc3KR^aK/atvF0|QQ*$f8q7p&oBIOHdpy)u0qAAyu{3Q+w');

/**#@-*/

/**
 * WordPress database table prefix.
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
```

```wp-install.sh
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
```

```www.conf
[www]

user = www-data
group = www-data

listen = wordpress:9000

listen.owner = www-data
listen.group = www-data

pm = dynamic

pm.max_children = 5

pm.start_servers = 2

pm.min_spare_servers = 1

pm.max_spare_servers = 3
```

# MariaDB

MariaDB is a fast, free, and reliable database system that stores and manages data for websites and apps.


## MariaDB vs MySQL quite simple:

- Sun bought MySQL.
- Oracle bought Sun.
- Oracle is a evil company (really, they are).
- Oracle declared MySQL developement model close (no outside contributions).
- Some of the original founders of MySQL forked it and created MariaDB a free clone of MySQL.
- Most/all Linux distributions have dropped MySQL from their repositories over the last decade plus in favor of MariaDB.
- Is all politics, really.
- When in doubt just go for Postgresql.


```Dockerfile
FROM debian:bullseye

RUN apt update && apt upgrade -y && apt install -y mariadb-server
RUN mkdir /run/mysqld

WORKDIR app/

COPY 50-server.cnf /etc/mysql/mariadb.conf.d/.
COPY script.sh .
RUN chmod +x script.sh

ENTRYPOINT ["./script.sh"]
```

```50-server.cnf
[server]

[mysqld]

user                    = root
pid-file                = /run/mysqld/mysqld.pid
basedir                 = /usr
datadir                 = /var/lib/mysql
tmpdir                  = /tmp
lc-messages-dir         = /usr/share/mysql
lc-messages             = en_US
skip-external-locking

bind-address            = mariadb

expire_logs_days        = 10
character-set-server  = utf8mb4
collation-server      = utf8mb4_general_ci

[embedded]

[mariadb]
[mariadb-10.5]
```


```script.sh
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
GRANT ALL PRIVILEGES ON wp_site.* TO 'jburlama'@'%' IDENTIFIED BY 'Jhonas123!';
FLUSH PRIVILEGES;
EOF

exec mariadb
```

# Ftp

FTP (File Transfer Protocol) is like a digital delivery truck for moving files between computers over the internet.

vsFTPd (Very Secure FTP Daemon) is a lightweight, fast, and secure FTP server for Linux/Unix systems. It’s designed to be simple and highly secure for file transfers.

```Dockerfile
FROM debian:buster

WORKDIR app/

RUN apt update && apt upgrade -y
RUN apt install vsftpd -y

COPY script.sh .
COPY vsftpd.userlist /etc/.
COPY vsftpd.conf /etc/.

ENTRYPOINT ["./script.sh"]
```

```script.sh
#!/bin/sh

service vsftpd start

adduser jburlama --disabled-password

echo "jburlama:$PASSWD" | chpasswd
echo "jburlama" | tee -a /etc/vsftpd.userlist 

mkdir /home/jburlama/ftp

chown nobody:nogroup /home/jburlama/ftp
chmod a-w /home/jburlama/ftp

mkdir /home/jburlama/ftp/files
chown jburlama:jburlama /home/jburlama/ftp/files

service vsftpd stop

vsftpd
```

```vsftpd.conf
listen=YES
anonymous_enable=NO
local_enable=YES
write_enable=YES
local_umask=022
chroot_local_user=YES
allow_writeable_chroot=YES
pasv_enable=YES
pasv_min_port=40000
pasv_max_port=40005
userlist_enable=YES
userlist_deny=NO
seccomp_sandbox=NO
nopriv_user=ftp
pam_service_name=vsftpd
userlist_file=/etc/vsftpd.userlist
```

```vsftpd.userlist
jburlama
```

# Redis

Redis (Remote Dictionary Server) is a super-fast in-memory database that stores data in RAM instead of on disk, making it ideal for caching, real-time apps, and speedy lookups.


```Dockerfile
FROM debian:buster

RUN apt-get -y update && apt install redis-server -y

COPY redis.conf /etc/redis/.

RUN chown redis:redis /etc/redis/redis.conf

ENTRYPOINT ["redis-server", "/etc/redis/redis.conf"]
```

```redis.conf
bind 0.0.0.0
protected-mode no
port 6379
tcp-backlog 511
databases 16
always-show-logo yes
maxmemory 256mb
maxmemory-policy allkeys-lru
````

# Cadvisor

cAdvisor (Container Advisor) is like a health monitor for your containers. It tracks real-time performance and resource usage (CPU, memory, disk, network) of running containers—helping you spot issues before they crash your apps.

```Dockerfile
FROM debian:bullseye

WORKDIR app/

RUN apt update -y
RUN apt install wget -y && wget https://github.com/google/cadvisor/releases/download/v0.37.0/cadvisor && chmod +x cadvisor

ENTRYPOINT ["./cadvisor"]
```
