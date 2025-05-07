FROM debian:buster

RUN apt-get -y update && apt install redis-server -y

COPY redis.conf /etc/redis/.

# RUN echo "vm.overcommit_memory=1" >> /etc/sysctl.conf
# ENTRYPOINT ["redis-server", "--protected-mode", "no"]

ENTRYPOINT ["redis-server", "/etc/redis/redis.conf"]

