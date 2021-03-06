# The Rog Schedule Project

[![CircleCI](https://circleci.com/gh/hieudt-2054/rog-schedule.svg?style=svg)](https://circleci.com/gh/hieudt-2054/rog-schedule)
[![GithubAction](https://github.com/hieudt-2054/rog-schedule/workflows/Laravel/badge.svg)](https://github.com/hieudt-2054/rog-schedule)
[![GithubAction](https://github.com/hieudt-2054/rog-schedule/workflows/Code_Quality/badge.svg)](https://github.com/hieudt-2054/rog-schedule)
[![GithubAction](https://github.com/hieudt-2054/rog-schedule/workflows/ROGLabel/badge.svg)](https://github.com/hieudt-2054/rog-schedule)
[![Known Vulnerabilities](https://snyk.io/test/github/hieudt-2054/rog-schedule/badge.svg?targetFile=package.json)](https://snyk.io/test/github/hieudt-2054/rog-schedule?targetFile=package.json)

## Requirements Environments

- [Laravel 6.x](https://laravel.com/docs/6.x)
- [Docker >= 18.06.1-ce](https://docs.docker.com/install)
- [Docker-compose >= 1.24.0](https://docs.docker.com/compose/install)
- [PHP >= 7.3](https://www.php.net/downloads.php)
- [Mysql >= 5.7](https://dev.mysql.com/downloads/installer/)
- [Nginx > = nginx/1.15.7](https://www.nginx.com/resources/wiki/start/topic/tutorials/install/)
- [Yarn >= 1.15.0](https://yarnpkg.com/en/docs/install#debian-stable)


## Library Usage
- [Sentry SDK](https://sentry.io)
- [Laravel Socialite](https://laravel.com/docs/6.x/socialite)
- [Laravel Passport](https://laravel.com/docs/6.x/passport)
- [Vuex](https://vuex.vuejs.org/guide/)
- [Vuetify](https://vuetifyjs.com/en/)

## Setup

- Copy file `.env.example` to `.env`,
- Modify `.env` config file (optional). If you modify the `mysql`, `mongo`, `redis` configurations in `.env` file, remember to modify the configurations in `docker-compose.yml` file too.

- Install or run Docker
```BASH
docker-compose up -d
# Stop
docker-compose stop
```

- Site will publish on 127.0.0.1:{`ports`} (`ports` config in docker-compose.yml > services > ngix > ports). Add domain to host file so we can access site by domain:{`ports`} (edit host in file ./ect/hosts)

```
127.0.0.1 rogschedule.local
```
- Asset project with domain

```
rogschedule.local:2021 or localhost:2021 or 127.0.0.1:2021
```

- `chmod` cache folders
```BASH
chmod -R 777 storage
chmod -R 777 bootstrap/cache
```

### Installation

- Go into the `workspace` container

```BASH
docker exec -it rogschedule_workspace bash
```

```BASH
composer install
php artisan key:generate
```

- Install node modules
```BASH
yarn install
```

- Build
```BASH
yarn run dev
```

- Run migration

```BASH
# Check Docker Container list, copy the `workspace` container name
docker ps
# Go into the `workspace` container
docker exec -it rogschedule_workspace bash
# Run migration
php artisan passport:install
php artisan migrate --seed
# Or running outside the docker container
docker exec -it rogschedule_workspace php artisan migrate --seed
```

- If you want run project on your local instead of Docker, just skip all step about docker and create virtual host. And modify `.env` config of `DB_HOST`, `DB_HOST_TEST`, `REDIS_HOST` to `127.0.0.1`

## CI/CD SDK Optional
```BASH
# Check eslint convention
yarn run eslint
# Fix eslint auto
yarn run eslint:fix
# Configuration deploy with Deployer ( deploy.php )
dep deploy -vv
# Library configuration file public
Add SENTRY_LARAVEL_DSN key to .env
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```

## Application Monitor
```BASH
# change LOG_CHANNEL from stack to daily in .env
APP_URL=http://localhost

LOG_CHANNEL=daily
Go to http://localhost:2021/log-viewer

```
