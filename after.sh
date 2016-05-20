#!/usr/bin/env bash

sudo locale-gen nl_NL.utf8
sudo update-locale

php /home/vagrant/dagvandeweek/app/console doctrine:schema:create
php /home/vagrant/dagvandeweek/app/console fos:user:create admin admin@stefanius.nl 1234
