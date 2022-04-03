Getting Started
---------------
```
make composer-install wd=./
docker-compose up -d --build
```

php-cs-fixer
------------
```
make composer-install wd=tools/php-cs-fixer
make fix-cs
```

Usage
-----
```
curl -X GET http://localhost:8088/offers?criteria=cheapest | jq
curl -X POST http://localhost:8088/confirm --data-urlencode 'id=first::1232' | jq
```