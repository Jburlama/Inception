FROM debian:buster

WORKDIR app/

RUN apt update && apt upgrade -y
RUN apt install vsftpd -y

COPY script.sh .

CMD ["./script.sh"]

