CONTAINERS = nginx wordpress mariadb redis ftp cadvisor
IMAGES = nginx:42 wordpress:42 mariadb:42 redis:42 ftp:42 cadvisor:42
COMPOSE_PATH = ./srcs/docker-compose.yml


up: build
	docker compose -f ${COMPOSE_PATH} up -d

build:
	docker compose -f ${COMPOSE_PATH} build

rmi:
	docker rmi -f ${IMAGES}

kill:
	docker kill ${CONTAINERS}

down:
	docker compose -f ${COMPOSE_PATH} down

prune:
	docker system prune -a

re: kill rmi prune build

clean: kill

fclean: kill rmi prune
