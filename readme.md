# Basic Account API

Basic API to manage users and highscores.

This api was created to test the Unity [**RESTFul client library**](https://github.com/oswaldocarvalho/unity-restful-client)

Theres a runing version in 
http://basic-account-api.reptilaw.com, with test ENVs (APP_ENV=local AND APP_DEBUG=true). **The database is cleaned periodically.**

## Running locally with the docker-compose

1. Managing the API with **SQLite 3** database:
```
docker-compose -f docker-compose-sqlite.yml up -d
```

2. Managing the API with **MySQL 5.7** database:
```
docker-compose -f docker-compose-mysql.yml up -d
```
---
## Docker Hub

You can find this image in [**Docker Hub**](https://hub.docker.com/r/dreadnought/basic-account-api/).

Enviroment variables needed to run this image:

```
# name of yor application
APP_NAME=MyAppName

# local or production
APP_ENV=local

# debug mode? true/false
APP_DEBUG=true

# lumen thing
APP_KEY=ABigKeyHere

# stack, single, dayly, slack, syslog or errorlog
LOG_CHANNEL=single

# apc, array, database, file, memcached or redis
CACHE_DRIVER=file
```

MySQL specific
```
# connection driver
DB_CONNECTION=mysql

# hostname or ip addres of the server
DB_HOST=database

# connection port
DB_PORT=3306

# database name (will be created in first run)
DB_DATABASE=apidb

# database username
DB_USERNAME=root

# database password
DB_PASSWORD=secret
```

SQLite specific
```
# connection driver
DB_CONNECTION=sqlite

# SQLite file location
DB_DATABASE=/var/www/src/storage/apidb.sqlite
```
