#!/bin/bash

echo 'Deploying...'
cd /var/www/cmgbufet.cz

composer install 2>&1;
npm install
bower install
grunt install

echo 'Deployment finished successfully.'