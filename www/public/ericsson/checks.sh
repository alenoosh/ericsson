#!/bin/bash

echo -e "\nExecuting php -l (Syntax Check) for $1 : \n"
php -l $1
echo -e "\nExecuting phpcs for $1 : \n"
phpcs --standard=PSR2 $1
echo -e "\nExecuting phpmd for $1 : \n"
/var/www/vendor/bin/phpmd $1 xml naming,codesize,unusedcode,design
echo -e "\nExecuting phpcpd for $1 : \n"
/var/www/vendor/bin/phpcpd --min-lines 3 --min-tokens 50 $1
