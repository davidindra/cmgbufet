#!/bin/bash

echo 'Deploying...'
cd /var/www/cmgbufet.davidindra.cz

composer install
npm install
bower install
grunt install

echo 'Deployment finished successfully.'