php -d memory_limit=-1 composer.phar update
php bin/console cache:clear
php bin/console assetic:dump
php bin/console cache:clear