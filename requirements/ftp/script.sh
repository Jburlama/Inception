#!/bin/bash


service vsftpd start

# Add the USER, change his password and declare him as the owner of wordpress folder and all subfolders

adduser jburlama --disabled-password

echo "jburlama:Jhonas123!" | /usr/sbin/chpasswd

echo "jburlama" | tee -a /etc/vsftpd.userlist 


mkdir /home/jburlama/ftp


chown nobody:nogroup /home/jburlama/ftp
chmod a-w /home/jburlama/ftp

mkdir /home/jburlama/ftp/files
chown jburlama:jburlama /home/jburlama/ftp/files

sed -i -r "s/#write_enable=YES/write_enable=YES/1"   /etc/vsftpd.conf
sed -i -r "s/#chroot_local_user=YES/chroot_local_user=YES/1"   /etc/vsftpd.conf

echo "
local_enable=YES
allow_writeable_chroot=YES
pasv_enable=YES
local_root=/home/jburlama/ftp
pasv_min_port=40000
pasv_max_port=40005
userlist_file=/etc/vsftpd.userlist" >> /etc/vsftpd.conf

service vsftpd stop


/usr/sbin/vsftpd
