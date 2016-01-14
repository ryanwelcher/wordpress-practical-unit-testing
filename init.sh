#!/usr/bin/env bash


if [ ! -d "core" ]; then
    mkdir core
    cd core
    wp core download
fi
cd core
wp core config --dbname=plugin_demo --dbuser=root --dbhost=127.0.0.1
wp core install --url=http://demo.com --title=demo --admin_user=admin --admin_password=password --admin_email=email@email.com

mkdir wp-content/plugins/plugin-demo
#wp scaffold plugin-tests plugin-demo -path="/core"