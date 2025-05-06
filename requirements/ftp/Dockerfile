FROM debian:bullseye

WORKDIR app/

RUN apt update && apt upgrade -y && apt install vsftpd -y

RUN adduser jburlama --disabled-password
# RUN echo "jburlama:$PASSWD" | chpasswd

COPY vsftpd.conf /etc/.
COPY vsftpd.userlist /etc/.

ENTRYPOINT ["vsftpd"]
