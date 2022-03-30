composer-install:
	docker run --rm \
	--volume $(CURDIR):/app \
	--interactive \
	composer:2.2.9 \
	composer install \
	--no-suggest \
	--prefer-dist \
	--optimize-autoloader