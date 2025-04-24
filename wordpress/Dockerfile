FROM debian:bullseye

RUN apt update && apt upgrade -y \
	&& apt install php7.4-fpm php7.4-mysqli curl -y \
	&& mkdir -p /run/php

RUN mkdir -p /run/php && chown -R www-data:www-data /run/php

COPY www.conf /etc/php/7.4/fpm/pool.d/.

EXPOSE 9000

ENTRYPOINT ["/usr/sbin/php-fpm7.4", "-F"]

