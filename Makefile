build:
	docker compose up -d --build --remove-orphans

up:
	docker compose up -d --remove-orphans

rmi:
	docker rmi -f nginx:custom wordpress:custom mariadb:custom

kill:
	docker kill nginx wordpress mariadb


re: kill rmi build
