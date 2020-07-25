# VI.Tech test app

## API

TBD

## Используемые технологии

- PHP 7.4.1
- MySQL 5.7

## Запуск приложения

- Запустить `nginx-proxy` контейнер

```
docker network create nginx-proxy
docker run -d --restart=always \
  --name global_nginx \
  -p 80:80 \
  --network="nginx-proxy" \
  -v /var/run/docker.sock:/tmp/docker.sock:ro \
  jwilder/nginx-proxy

```

- Добавить `vi-test.loc` в `/etc/hosts`
- `docker-compose up -d`