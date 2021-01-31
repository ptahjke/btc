для запуска проекта выполнить из корня
```
    docker-compose build --no-cache
    docker-compose up
    docker exec -it btc_fpm bash
    composer install
```
не успел сделать установку зависимостей при старте контейнеров
```
get http://localhost:8001/api/v1?method=rates&currency=USD
post http://localhost:8001/api/v1 + body params
```
