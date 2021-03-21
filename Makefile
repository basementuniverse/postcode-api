DOCKER=docker-compose exec php

.PHONY: build
build:
	docker-compose build

.PHONY: up
up:
	docker-compose up -d

.PHONY: down
down:
	docker-compose down

.PHONY: import-postcodes
import-postcodes:
	$(DOCKER) php bin/console import:postcodes

.PHONY: migrate
migrate:
	$(DOCKER) php bin/console doctrine:migrations:migrate
