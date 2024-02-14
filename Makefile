include .env

UID:=`id -u`
GID:=`id -g`
UIDS:=UID=${UID} GID=${GID}
PHP_FPM:=${UIDS} docker compose exec php-fpm
PG_VOLUME:=fast_pg_data

up:
	${UIDS} docker compose up -d

down:
	${UIDS} docker compose down --remove-orphans

restart: down up

pull-php:
	docker pull ${APP_IMAGE_PHP} || /bin/true
pull-front:
	docker pull ${APP_IMAGE_FRONTEND} || /bin/true
pull-dashboard:
	docker pull ${APP_IMAGE_DASHBOARD} || /bin/true

pull: pull-php

dropdb:
	docker volume rm -f ${PG_VOLUME}

reinit: down pull dropdb up

bash:
	${PHP_FPM} bash

console: bash

route-list:
	${PHP_FPM} bash -c 'php artisan route:list'

clean:
	sudo rm -rf vendor .env

tinker:
	${PHP_FPM} php artisan tinker

db-seed:
	${PHP_FPM} php artisan db:seed --class=DatabaseSeeder

dev-seed:
	${PHP_FPM} php artisan db:seed --class=DevSeeder

test:
	${PHP_FPM} ./vendor/bin/phpunit -d --memory_limit=1G $(arg)

ci: test
