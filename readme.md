# BileMo

##### BileMo is the 7th project of OpenClassrooms back-end course.
###### This project gives access to the BileMo's API for users, managed by its client.


### Tech

BileMo uses tehcnologies below :

- PHP with Symfony & MySQL

## Installation

BileMo requires [PHP](https://php.net) 8.0.1 to run.

Install the bundles
You have to create a _.env_ file in /BileMo folder with your parameters
```sh
APP_ENV=dev
APP_SECRET=

DATABASE_URL="mysql://root:password@host:port/BileMo?serverVersion=5.7"
```
And then
```sh
cd BileMo
composer install
php bin/console make:db
symfony serve
```
The _"php bin/console make:db"_ script command will drop the database (if exists), create a new one, update the schema and load the fixtures.

You can now request _BileMo_ locally on http://localhost:[port]