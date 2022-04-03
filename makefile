# make composer-install wd=./ - main composer file
# make composer-install wd=tools/php-cs-fixer - cs-fixer composer file
composer-install:
	docker run --rm \
	--volume $(CURDIR):/app \
	--interactive \
	composer:2.2.9 \
	composer install \
	--no-suggest \
	--prefer-dist \
	--optimize-autoloader \
	--working-dir=$(wd)

fix-cs:
	docker-compose \
	-f docker-compose.yml \
	exec -T php php /code/tools/php-cs-fixer/vendor/bin/php-cs-fixer fix /code/src