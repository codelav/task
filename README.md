# run:
    make composer-install wd=./
    docker-compose up -d --build
#php-cs-fixer:
    make composer-install wd=tools/php-cs-fixer
    make fix-cs