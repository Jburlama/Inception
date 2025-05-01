FROM debian:bullseye

WORKDIR app/

RUN apt update && apt upgrade -y && apt install vsftpd -y

COPY vsftpd.conf /etc/.

ENTRYPOINT ["vsftpd"]
