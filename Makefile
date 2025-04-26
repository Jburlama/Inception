build:
	docker compose up -d --build --remove-orphans

up:
	docker compose up -d --remove-orphans

rmi:
	docker rmi -f nginx:42 wordpress:42 mariadb:42

kill:
	docker kill nginx wordpress mariadb

down:
	docker compose down

prune:
	docker builder prune -f

re: kill rmi prune build
