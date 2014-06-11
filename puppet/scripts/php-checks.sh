#!/bin/bash 

pear_path="which pear"

wget https://phar.phpunit.de/phpcpd.phar
chmod +x phpcpd.phar
mv phpcpd.phar /usr/local/bin/phpcpd

$pear_path channel-discover pear.phpmd.org
$pear_path channel-discover pear.pdepend.org
$pear_path install --alldeps phpmd/PHP_PMD

exit 0;
