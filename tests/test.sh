#/!bin/bash

LOG_FILE_NAME=$1
if [ -z "$LOG_FILE_NAME" ]; then
	LOG_FILE_NAME='test.dump'
fi;
log=/tmp/$LOG_FILE_NAME
echo > $log

rm -rf vendor
rm -rf composer.lock
composer install --dev
rm -rf /tmp/SocialBundle

/usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests >> $log 2>&1
status=$(cat $log | grep "ERRORS!")
[ -z "$status" ] && exit 0 ||  exit -1