#! /bin/bash

#
# install and configure btrade
# docker build -t btrade docker/ && docker run --name=btrade -p 127.0.0.1:8080:8080 btrade
#

phpenmod trader
phpenmod mcrypt
service php7.1-fpm start
service mysql start
service redis-server start
adduser www-data root

pushd /etc/nginx/sites-enabled
ln -s ../sites-available/btrade.conf .
popd

mysqladmin -u root password password
echo "CREATE DATABASE btrade;" | mysql -u root -ppassword

cd /var/www
git clone https://github.com/lborget/btrade
cd btrade

# Laravel needs these to be writable
chmod 777 storage/logs
chmod 777 bootstrap/cache

pip install python-env

echo "-----------------------------------------------------------------"
echo "------ THIS IS GOING TO TAKE A LITTLE WHILE ..... please wait. --"
echo "-----------------------------------------------------------------"
composer update
cp .env.example .env

ln -s /var/www/btrade/public /var/www/html/btrade

mkfifo quotes
mysql -u root -ppassword -D btrade < app/Scripts/DBdump.sql

#php artisan btrade:example_usage

#/usr/bin/crontab /usr/src/crontab.tmp
#/usr/sbin/service cron start

echo "TESTING REST API via: http://127.0.0.1:8080/api/accounts"
curl http://127.0.0.1:8080/api/accounts

echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "+----- READ ME:                                                     -----+"
echo "+------------------------------------------------------------------------+"
echo "+----- btrade is now set up:                                       -----+"
echo "+----- you need to modify your /root/btrade/.env                   -----+"
echo "+-----                                                              -----+"
echo "+----- SWAP TO A DIFFERENT TERMINAL TO CONNECT TO THIS INSTANCE     -----+"
echo "+----- USE: 'docker exec -it btrade /bin/bash' to get  access      -----+"
echo "+-----                                                              -----+"
echo "+-----  oanda streaming is going to 'Fatal' exit until              -----+"
echo "+-----  you set your OANDA_TOKEN in .env                            -----+"
echo "+-----                                                              -----+"
echo "+-----  use: 'php artisan btrade:example_usage' for testing .env   -----+"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"

# fire up supervisord
/usr/bin/supervisord