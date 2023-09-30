# Micro

then prepare docker environment:
```
docker compose build
docker compose up -d
docker compose run php bash
```

final project steps inside of docker container:
```
composer install
bin/console doctrine:database:create
bin/console doctrine:schema:create
bin/console doctrine:schema:update
```


```
docker exec -it app-private-files bash
./vendor/bin/phpunit --colors --verbose --testdox
bin/console app:import-from-csv --import-orders --force
ps auxf
bin/console messenger:consume --env=prod --limit=1 --failure-limit=2 --no-debug
```

```
docker exec -it app-cron bash
```


https://github.com/thebiggive/mailer
https://thecodest.co/blog/microservices-communication-in-symfony-part-i-1/
https://ivan.bessarabov.ru/blog/how-to-run-cron-in-docker?ysclid=lm5y5j70z4343412343

## Cron
https://www.airplane.dev/blog/docker-cron-jobs-how-to-run-cron-inside-containers
https://github.com/nitesh-/docker-cron-with-environment-variables