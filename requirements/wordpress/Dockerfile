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
