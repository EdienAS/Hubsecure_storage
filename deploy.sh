docker-compose down
docker-compose build
docker-compose run --rm composer update
#docker-compose run --rm artisan migrate
sleep 10
docker-compose up -d --remove-orphans
sleep 10
docker-compose run --rm artisan migrate
docker-compose run --rm artisan db:seed
rm -rf storage_app/public/storage
docker-compose run --rm artisan storage:link || true
echo "Done"
echo ""
echo "http://localhost"
