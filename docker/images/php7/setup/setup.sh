#!/bin/bash

echo -e "****************************************************"
echo -e "SETUP IMAGE PHP7"
echo -e "****************************************************"

echo -e "ADD USER VOLFIELD"
useradd -ms /bin/bash -u 1000 volfield

echo "PARTAGE DE GROUPE VOLFIELD / WWW-DATA"
echo -e "www-data dans volfield"
usermod -a -G www-data volfield
echo -e "volfield dans www-data"
usermod -a -G volfield www-data

docker-php-ext-install pdo pdo_mysql

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
rm /etc/apt/preferences.d/no-debian-php
apt-get update
apt-get install -y wget ssh git zip unzip pdftk ghostscript libpcre3-dev zlib1g-dev libzip-dev libpng-dev build-essential wkhtmltopdf
docker-php-ext-configure intl
docker-php-ext-configure soap --enable-soap
docker-php-ext-configure zip --with-libzip=/usr/include
docker-php-ext-install soap
docker-php-ext-install zip
docker-php-ext-install intl
docker-php-ext-install gd
docker-php-ext-install opcache
docker-php-ext-enable opcache

pecl install -o -f apcu \
&& echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini

pecl install -o -f xdebug \
&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini
pecl install -o -f zip intl opcache \
&& echo "extension=zip.so" >> /usr/local/etc/php/conf.d/php.ini

mkdir -p /www
chgrp -R www-data /www
chmod -R 775 /www

apt-get install -y php-soap
apt-get install -y libxml2-dev
docker-php-ext-install soap
docker-php-ext-configure soap --enable-soap

wget https://downloads.wkhtmltopdf.org/0.12/0.12.5/wkhtmltox_0.12.5-1.stretch_amd64.deb
apt-get install fontconfig libxrender1 xfonts-75dpi xfonts-base
apt --fix-broken install
dpkg -i  wkhtmltox_0.12.5-1.stretch_amd64.deb


echo -e "****************************************************"
echo -e "END"
echo -e "****************************************************"
