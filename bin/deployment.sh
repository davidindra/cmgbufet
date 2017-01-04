#!/bin/bash

echo 'Deploying...'
cd /var/www/cmgbufet.cz

composer install 2>&1;
npm install
bower install
grunt

echo 'Deployment finished successfully.'