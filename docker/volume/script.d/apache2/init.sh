#!/bin/bash

echo -e "****************************************************"
echo -e "INIT APACHE2"
echo -e "****************************************************"

source /home/volfield/script.d/common/colors.sh
source /home/volfield/script.d/common/bashrc.sh

a2enmod rewrite
a2enmod headers
a2enmod ssl

service apache2 reload

echo -e "****************************************************"
echo -e "END"
echo -e "****************************************************"