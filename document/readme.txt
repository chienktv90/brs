1. Practices main
Background RESTful API, OOP, MVC, SRP (Single Responsibility Principle), Microservice
Implementation service such as: register, login, import csv, list
Inter-service communication: authencation before upload file csv with more than 1 million row and insert into mysql.


2 Folder project
framework: laravel 8.4
package: passport
Technical: Queues and Job Batching


3 Step by step run on local computer
3.1 Requirement
- Install xampp server
PHP Version >= 7.3.7 && Mysql
- Install composer


3.2 Config database
create database name brsdb or import database sample ready!


3.3 open terminal run command
php artisan key:generate
php artisan migrate
php artisan queue:work 

(note: not kill or close windown when run command php artisan queue:work)


4. TEST API By Postman
use csv sample ready!
step by step includes: register account -> login -> upload file csv

IMPORT Collection to postman

https://www.postman.com/collections/85d0de331d463cac1612
or
you import a file BRS.postman_collection.json to postman 

END-POINT document
https://documenter.getpostman.com/view/11594629/TzRVfRkf

--------
account login if you use database sample
username: chienktv90
password: 123456

'headers' => [
    'Accept' => 'application/json',
    'Authorization' => 'Bearer '.$accessToken,
]

--------------------------------------------
Auth
http://localhost/brs/public/api/register
http://localhost/brs/public/api/login

Transaction import file csv
http://localhost/brs/public/api/upload

Top 5 latest transaction and total records
http://localhost/brs/public/api/transaction



5. Continue developing
import file excel
validation data