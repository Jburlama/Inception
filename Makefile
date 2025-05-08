containers = nginx wordpress mariadb redis ftp cadvisor
images = nginx:42 wordpress:42 mariadb:42 redis:42 ftp:42 cadvisor:42


build:
	docker compose up -d --build --remove-orphans

up:
	docker compose up -d --remove-orphans

rmi:
	docker rmi -f images

kill:
	docker kill conatiners

down:
	docker compose down

prune:
	docker builder prune -f

re: kill rmi prune build

clean: kill

fclean: kill rmi prune
