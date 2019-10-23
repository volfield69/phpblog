include ./docker/rules.mk
include ./docker/make/Makefile.docker
include ./docker/make/Makefile.git


################################
################################
##### Generate compose dev #####
################################

install:
	# Création du fichier avec les identifiants utilisateurs
	$(MAKE) docker-compose-dev.yml

	# Import des images docker nécessaires
	$(MAKE) docker-build-mysql57-image
	$(MAKE) docker-build-php7-image
	# Lancement des containers
	$(MAKE) docker-up



docker-up: docker-compose-up 
	$(MAKE) docker-init-all

docker-start: docker-compose-start

docker-stop: docker-compose-stop


#####################################
##### Initialisation containers #####
#####################################

docker-init-all:
	$(MAKE) docker-init-mysql57
	$(MAKE) docker-init-php7

docker-init-mysql57:
	# Scripts d'initialisation pour ${PROJECTS}_mariadb_1
	docker exec -i -t ${PROJECTS}_mysql_1 bash /docker/script.d/mysql/init.sh

docker-init-php7:
	# Scripts d'initialisation pour ${PROJECTS}_symfony
	docker exec -i -t ${PROJECTS}_symfony_1 bash /home/volfield/script.d/apache2/init.sh
	docker exec -i -t ${PROJECTS}_symfony_1 bash /home/volfield/script.d/symfony/init.sh

#####################################
##### Creation des containers  ######
#####################################

docker-build-mysql57-image:
	$(MAKE) -C docker/images/mysql57 build
	$(MAKE) -C docker/images/mysql57 tag_latest

docker-build-php7-image:
	$(MAKE) -C docker/images/php7 build
	$(MAKE) -C docker/images/php7 tag_latest


############################
##### Login Containers #####
############################

bash-symfony:
	$(MAKE) docker-bash-as-volfield name=${PROJECTS}_symfony_1

bash-symfony-root:
	$(MAKE) docker-bash name=${PROJECTS}_symfony_1

bash-mysql:
	$(MAKE) docker-bash name=${PROJECTS}_mysql_1

################################
##### Generate compose dev #####
################################

docker-compose-dev.yml:
	@echo "version: \"2\"" > $@
	@echo "services:" >> $@
	@echo "    parent:" >> $@
	@echo "        environment: " >> $@
	@echo "            USER_ID: "$(shell id -u)"" >> $@
	@echo "            GROUP_ID: "$(shell id -g)"" >> $@


################################
##### Generate compose dev #####
################################

assets-dev:
	yarn encore dev

assets-watch:
	yarn encore dev --watch

assets-prod:
	yarn encore production


################################
##### GrumPHP #####
################################

cs-fix:
	vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix

grumphp:
	vendor/bin/grumphp run

check-security:
	vendor/sensiolabs/security-checker/security-checker security:check

check-duplicate-lines:
	vendor/sebastian/phpcpd/phpcpd src tests

check-magic-number:
	vendor/povils/phpmnd/bin/phpmnd src
