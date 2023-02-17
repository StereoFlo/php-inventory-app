# Run the app (WIP)

```shell
docker-compose up --build
```

### Available routes
`GET /devices/:device_id`


# Utils

### php-cs-fixer
```shell
php vendor/bin/php-cs-fixer fix  --diff src --config=.php-cs-fixer.dist.php
```
### phpstan
```shell
php vendor/bin/phpstan analyse src -c phpstan.neon
```
### phpunit
```shell
php php bin/phpunit
```