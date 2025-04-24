FROM debian:bullseye

WORKDIR app/

EXPOSE 3306

RUN apt update && apt upgrade -y && apt install -y mariadb-server

COPY 50-server.cnf /etc/mysql/mariadb.conf.d/.

COPY script.sh .

RUN chmod u+x script.sh

RUN mkdir /run/mysqld

ENTRYPOINT ["./script.sh"]
