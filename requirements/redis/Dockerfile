FROM debian:bullseye

WORKDIR app/
RUN apt update && apt upgrade -y && apt install redis-server -y

COPY redis.conf /etc/redis/.

ENTRYPOINT ["redis-server"]
