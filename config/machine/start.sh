#!/bin/bash

# Tweak nginx to match the workers to cpu's
if [ $APP_ENV = "production" ]; then
    procs=$(cat /proc/cpuinfo |grep processor | wc -l)
    sed -i -e "s/worker_processes 5/worker_processes $procs/" /etc/nginx/nginx.conf
fi

# SQLite problems...
if [ $DB_CONNECTION = "sqlite" ]; then
    # create the sqlite database if not exists
    if [ ! -f $DB_DATABASE ]; then
        echo "Creating database file"
        touch $DB_DATABASE
    fi
fi

# MySQL problems...
if [ $DB_CONNECTION = "mysql" ]; then
    echo "Checking MySQL connection..." >> /dev/stdout
    while true; do
        mysql_ok=$(php -r 'try { new PDO(sprintf("mysql:host=%s;port=%s;dbname=%s", getenv("DB_HOST"), getenv("DB_PORT"), getenv("DB_DATABASE")), getenv("DB_USERNAME"), getenv("DB_PASSWORD")); echo "OK";}catch(Exception $e){ echo "ERR";}')

        if [ $mysql_ok = "ERR" ]; then
            echo "MySQL offline..."
            sleep 1
        else
            echo "MySQL ONLINE!"
            break
        fi
    done
fi

# database migration
/var/www/src/artisan migrate --force

# Again set the right permissions
chown -Rf nginx:nginx /var/www/src

# Load contrab schedules
crontab /etc/schedule.txt

# Start supervisord and services
exec supervisord -c /etc/supervisord.conf
