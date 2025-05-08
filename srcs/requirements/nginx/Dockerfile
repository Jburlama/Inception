FROM debian:bullseye

RUN apt update && apt upgrade -y && apt install nginx openssl -y \
	&& mkdir -p /etc/nginx/ssl \
	&& openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
		-keyout /etc/nginx/ssl/private.key \
		-out /etc/nginx/ssl/certificate.crt \
		-subj "/CN=nginx" \
	&& chmod 600 /etc/nginx/ssl/private.key \
	&& chmod 644 /etc/nginx/ssl/certificate.crt

COPY default.conf /etc/nginx/conf.d/.

ENTRYPOINT ["nginx", "-g", "daemon off;"]
