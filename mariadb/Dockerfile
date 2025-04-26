FROM debian:bullseye

RUN apt update && apt upgrade -y && apt install -y mariadb-server
RUN mkdir /run/mysqld

WORKDIR app/

COPY 50-server.cnf /etc/mysql/mariadb.conf.d/.
COPY script.sh .
COPY init.sql .
RUN chmod +x script.sh

ENTRYPOINT ["./script.sh"]
