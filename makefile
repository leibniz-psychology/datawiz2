
composer.lock: composer.json
	composer update

vendor/: composer.lock
	composer install

npm-shrinkwrap.json: package.json
	npm shrinkwrap 

node_modules/: package-lock.json
	npm install

