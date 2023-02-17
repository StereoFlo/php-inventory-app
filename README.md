# Run the app (WIP)

```shell
docker-compose up --build
```

# Disclaimer

this is a ported version of the golang language app. The basic version of the server is [here](https://github.com/StereoFlo/go-inventory-app)

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