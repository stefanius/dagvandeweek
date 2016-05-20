#!/usr/bin/env bash

php /home/vagrant/dagvandeweek/app/console doctrine:schema:create
php /home/vagrant/dagvandeweek/app/console fos:user:create admin admin@stefanius.nl 1234
