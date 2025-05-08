FROM debian:buster

RUN apt-get -y update && apt install redis-server -y

COPY redis.conf /etc/redis/.

RUN chown redis:redis /etc/redis/redis.conf

ENTRYPOINT ["redis-server", "/etc/redis/redis.conf"]

