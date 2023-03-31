docker-compose build
docker-compose run --rm composer update
docker-compose run --rm artisan migrate
sleep 10
docker-compose up -d --remove-orphans
sleep 10
docker-compose run --rm artisan migrate
docker-compose run --rm artisan storage:link