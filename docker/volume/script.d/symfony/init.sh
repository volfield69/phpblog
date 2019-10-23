#!/bin/bash

echo -e "****************************************************"
echo -e "INIT SYMFONY"
echo -e "****************************************************"

source /home/volfield/script.d/common/colors.sh
source /home/volfield/script.d/common/bashrc.sh

cp /www/.env.dist /www/.env

su - volfield -c "umask 0002 && cd /www && php composer.phar install"
su - volfield -c "umask 0002 && cd /www && php bin/console doctrine:schema:update --force"
su - volfield -c "umask 0002 && cd /www && php bin/console asset:install"



echo_title "Installation phpunit"
cd /tmp
wget https://phar.phpunit.de/phpunit-6.4.phar
chmod +x phpunit-6.4.phar
mv phpunit-6.4.phar /usr/local/bin/phpunit
phpunit --version


echo_title "Fin installation de symfony"
