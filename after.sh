#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.
#
# If you have user-specific configurations you would like
# to apply, you may also create user-customizations.sh,
# which will be run after this script.

if [ ! -f /usr/local/extra_homestead_software_installed ]; then
    echo 'Installing some extra software...'
    sudo apt-get update --allow-releaseinfo-change
    sudo apt-get update

    # Change path after login
    echo '
    # Automatically change into sourcecode folder
    cd /home/vagrant/code' >> /home/vagrant/.zshrc

    # Composer install
    cd /home/vagrant/code
    composer install

    # setup application
    php artisan cache:clear
    php artisan migrate --seed

    # remember that the extra software is installed
    sudo touch /usr/local/extra_homestead_software_installed

    # and we're done
    echo "Done!"

else
    echo "Extra software already installed... moving on..."
fi