#!/bin/bash

echo 'Deploying...'
cd /var/www/cmgbufet.cz

rm -r temp/cache/*

composer install 2>&1;
npm install
bower install
grunt

php www/index.php orm:schema-tool:update --force

echo 'Deployment finished successfully.'