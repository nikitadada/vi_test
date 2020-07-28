# VI.Tech test app

## API

- создать товары: POST http://vi-test.loc/product/init  

Ответ:
```
{
    "productIds": [
        41,
        42,
        .
        .
        .
    ]
}
```

- создать заказ: POST http://vi-test.loc/order  

Передать в теле запроса:  
```
{"productIds": [21, 25, ...]}
```
Ответ:
``` 
{
   "orderId": 3,
   "orderStatus": "new"
} 
```

- оплатить заказ: POST http://vi-test.loc/order/{id}/pay  

Передать в теле запроса:  
```
{"amount": 500.25}
```
Ответ (В случае ошибки будет выброшено исключение):
``` 
{
   "orderId": 3,
   "orderStatus": "paid"
} 
```

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