build:
	@echo Initialize docker containers
	@docker-compose up -d

composer:
	@echo Install application
	@docker-compose exec -T php-fpm composer install

all:
	@echo Start
	@make -s build
	@make -s composer
	@echo End