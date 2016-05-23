#!/usr/bin/env bash

sudo locale-gen nl_NL
sudo locale-gen nl_NL.utf8

sudo locale-gen de_DE
sudo locale-gen de_DE.utf8

sudo locale-gen fr_FR
sudo locale-gen fr_FR.utf8

sudo update-locale
sudo apt-get install language-pack-NL
sudo apt-get install language-pack-DE
sudo apt-get install language-pack-FR

mysql -uhomestead -psecret dagvandeweek < /home/vagrant/dagvandeweek/database.sql

sudo service php7.0-fpm restart

php /home/vagrant/dagvandeweek/app/console doctrine:schema:create
php /home/vagrant/dagvandeweek/app/console fos:user:create admin admin@stefanius.nl 1234
