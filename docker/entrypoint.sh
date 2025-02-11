#!/bin/sh
set -e

cd /var/www/infra

if [ ! -f .env ]; then
  if [ -f .env.example ]; then
    cp .env.example .env
    echo ".env file created from .env.example"
  else
    echo "ERROR: .env.example not found in /var/www/infra"
    exit 1
  fi
fi

envsubst < .env > .env.tmp && mv .env.tmp .env

php artisan key:generate --force

php artisan migrate --seed

exec "$@"
