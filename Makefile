run:
	docker-compose up

stop:
	docker-compose down

composer-install:
	docker-compose run php composer install

symfony-check:
	docker-compose run web symfony check:requirements

build:
	USER_ID=`id -u` GROUP_ID=`id -g` docker-compose build

migrate:
	docker-compose run web php bin/console doctrine:migrations:migrate

db-create:
	docker-compose run web php bin/console doctrine:database:create
