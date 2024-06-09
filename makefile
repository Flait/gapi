stan:
	php vendor/bin/phpstan analyse -l max src tests

coverage:
	docker container exec gapi-php-fpm-1 ./vendor/bin/phpunit --coverage-html var/code-coverage

unit:
	docker container exec gapi-php-fpm-1 ./vendor/bin/phpunit tests


