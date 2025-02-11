#!/bin/sh
set -e

if [ ! -f .env ]; then
  cp .env.example .env
  echo ".env file created from .env.example"
fi


envsubst < .env > .env.tmp && mv .env.tmp .env

php artisan key:generate --force

php artisan migrate --seed --force

exec "$@"
