#Ottawa Swap and Buy
###Php5 Modules Needed
* php5-mcrypt
* php5-gd
* php5-mysql
* php5-memcached

###Daemons Needed
* memcached

###Initial steps
* Setup A Database
* Copy sample.env.php to .env.local.php
* Setup .env.local.php with seeding / database / email information
* Run composer install
* Run ./artisan migrate::install
* Run ./artisan migrate 
* Run ./artisan db::seed

###Tested With
* Php 5
* HHVM
* Apache2
* Nginx
* MySql

*Email Dave@Develops.io with any questions*
