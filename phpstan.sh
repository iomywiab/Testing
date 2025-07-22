#!/bin/bash

docker compose exec phpstan sh -c "php -d memory_limit=2G ./vendor/bin/phpstan analyse"
