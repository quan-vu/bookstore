export PROJECT_API=api

elastic_index_all_books := $(shell for n in 'seq 1 1000'; do docker-compose exec ${PROJECT_API} php artisan elastic:index-books 1000 ;done)


# Re-Initialize project from zero
init:
	@echo "\e[1;32mStep 1: Clean project all data, docker volumes, container\e[0m"
	docker-compose down -v
	@echo "\e[1;32mStep 2: Start project use Docker\e[0m"
	@cp .env.local .env
	docker-compose up -d
	@echo "\e[1;32mStep 3: Sleep 10s to wating for mysql complete started\e[0m"
	@sleep 10
	@echo "\e[1;32mStep 4: Setup Laravel project and migrate database\e[0m"
	docker-compose exec ${PROJECT_API} php artisan key:generate
	docker-compose exec ${PROJECT_API} php artisan migrate
	docker-compose exec ${PROJECT_API} php artisan key:generate --env=testing
	docker-compose exec ${PROJECT_API} php artisan migrate --env=testing
	docker-compose exec ${PROJECT_API} chown -R $USER:1000 /var/www/html
	docker-compose exec ${PROJECT_API} chmod o+w -R /var/www/html
	docker-compose exec ${PROJECT_API} php artisan test

up:
	docker-compose up -d

down:
	docker-compose down

clean:
	docker-compose down -v

composer:
	docker-compose exec ${PROJECT_API} composer install

migration:
	docker-compose exec ${PROJECT_API} php artisan make:migration $$name

migrate:
	docker-compose exec ${PROJECT_API} php artisan migrate

rollback:
	docker-compose exec ${PROJECT_API} php artisan migrate:rollback

model:
	docker-compose exec ${PROJECT_API} php artisan make:model $$name

seeder:
	docker-compose exec ${PROJECT_API} php artisan make:seeder $$name

db-sample:
	docker-compose exec ${PROJECT_API} php artisan db:seed --class=SampleSeeder

test-init:
	docker-compose exec ${PROJECT_API} php artisan key:generate --env=testing
	docker-compose exec ${PROJECT_API} php artisan migrate --env=testing
	docker-compose exec ${PROJECT_API} php artisan test

test:
	docker-compose exec ${PROJECT_API} php artisan test

test-filter:
	docker-compose exec ${PROJECT_API} php artisan test --filter=$$name

controller:
	docker-compose exec ${PROJECT_API} php artisan make:controller $$name

seed-one:
	docker-compose exec ${PROJECT_API} php artisan db:seed --class="$$name"

seed-sample-data:
	docker-compose exec ${PROJECT_API} php artisan db:seed --class=SampleDatabaseSeeder

seed-books:
	docker-compose exec ${PROJECT_API} php artisan db:seed --class=Database\\Seeders\\Sample\\SampleBookSeeder

## ElasticSearch
elastic-check:
	# curl localhost:9200
	docker-compose exec ${PROJECT_API} php artisan elastic:info

# Index 10.000 records
elastic-index-books:
	docker-compose exec ${PROJECT_API} php artisan elastic:index-books 10000

elastic-index-all-books:
	$(elastic_index_all_books)
