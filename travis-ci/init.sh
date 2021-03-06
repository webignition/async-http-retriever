#!/usr/bin/env bash

cd docker

docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build

echo "Waiting for mysql to accept connections ..."
while ! mysql -uroot -p${ASYNC_HTTP_RETRIEVER_MYSQL_ROOT_PASSWORD} --host mysql --port 33066 -e 'SELECT 1'; do
    sleep 1
done

docker-compose exec -T app-web composer install
docker-compose exec -T app-web ./bin/console doctrine:migrations:migrate --no-interaction

#docker-compose -f docker-compose.yml -f docker-compose.dev.yml stop
#docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
#docker-compose -f docker-compose.yml -f docker-compose.dev.yml ps
docker-compose logs app-cli

cd ..
