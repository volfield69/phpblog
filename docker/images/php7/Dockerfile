FROM php:7.2.3-apache

ADD setup /root/setup
RUN /bin/bash /root/setup/setup.sh

#RUN pecl install xdebug
RUN docker-php-ext-enable xdebug &&\
 echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
  echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
   echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
    echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
     echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
      echo "xdebug.default_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
        echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
         echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
          echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
           echo "xdebug.profiler_enable=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
            echo "xdebug.remote_handler = \"dbgp\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
             echo "xdebug.remote_log=\"/tmp/xdebug.log\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# add symfony shortcut
RUN echo 'alias sf="php bin/console"' >> /home/volfield/.bashrc &&\
 echo 'alias check_php="which php; whereis php; php --ini;"' >> /home/volfield/.bashrc &&\
  echo 'alias dump:autoload="composer dump-autoload"' >> /home/volfield/.bashrc &&\
   echo 'alias cache:clear="php bin/console cache:clear"' >> /home/volfield/.bashrc &&\
    echo 'alias debug:router="php bin/console debug:router"' >> /home/volfield/.bashrc &&\
     echo 'alias debug:autowiring="php bin/console debug:autowiring"' >> /home/volfield/.bashrc &&\
      echo 'alias change-password="php bin/console fos:user:change-password"' >> /home/volfield/.bashrc &&\
       echo 'alias create:user="php bin/console fos:user:create"' >> /home/volfield/.bashrc &&\
        echo 'alias user:promote="php bin/console fos:user:promote"' >> /home/volfield/.bashrc &&\
         echo 'alias dsud="php bin/console d:s:u --dump-sql"' >> /home/volfield/.bashrc &&\
          echo 'alias dsuf="php bin/console d:s:u --force"' >> /home/volfield/.bashrc &&\
           echo 'alias fixture:load="php bin/console doctrine:fixtures:load"' >> /home/volfield/.bashrc &&\
            echo 'alias d:m:d="php bin/console doctrine:migrations:diff"' >> /home/volfield/.bashrc &&\
             echo 'alias d:m:m="php bin/console doctrine:migrations:migrate"' >> /home/volfield/.bashrc &&\
              echo 'alias d:d:c="php bin/console doctrine:database:create"' >> /home/volfield/.bashrc &&\
               echo 'alias d:d:d="php bin/console doctrine:database:drop --force"' >> /home/volfield/.bashrc &&\
                echo 'alias do:migration="d:d:d; d:d:c; d:m:m; fixture:load;"' >> /home/volfield/.bashrc

WORKDIR /www



