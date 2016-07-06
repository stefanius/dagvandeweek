#!/usr/bin/env bash

sudo locale-gen nl_NL
sudo locale-gen nl_NL.utf8

sudo update-locale
sudo apt-get install language-pack-NL

mysql -uhomestead -psecret dagvandeweek < /home/vagrant/dagvandeweek.nl/database.sql

sudo service php7.0-fpm restart

#php /home/vagrant/dagvandeweek.nl/app/console doctrine:schema:create
php /home/vagrant/dagvandeweek.nl/app/console fos:user:create admin admin@stefanius.nl 1234
