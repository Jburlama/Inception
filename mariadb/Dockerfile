FROM debian:bullseye

WORKDIR app/


RUN apt update && apt upgrade -y && apt install -y mariadb-server

COPY 50-server.cnf /etc/mysql/mariadb.conf.d/.

COPY script.sh .

RUN chmod +x script.sh

RUN mkdir /run/mysqld

ENTRYPOINT ["./script.sh"]
