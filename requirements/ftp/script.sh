#!/bin/sh

service vsftpd start

adduser jburlama --disabled-password

echo "jburlama:$PASSWD" | chpasswd
echo "jburlama" | tee -a /etc/vsftpd.userlist 

mkdir /home/jburlama/ftp

chown nobody:nogroup /home/jburlama/ftp
chmod a-w /home/jburlama/ftp

mkdir /home/jburlama/ftp/files
chown jburlama:jburlama /home/jburlama/ftp/files

service vsftpd stop

vsftpd
