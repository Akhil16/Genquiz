# Genquiz

Genquiz is an online quiz platform for quizzes. Any registered user can create a quiz and share it among their friends. The questions in the quiz may be single choice, multiple choice or one word. This project is created in Laravel 5.4. 

### Prerequisites

```
Apache - Web Server
MySQLi - Database
PHP >= 5.6.4
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Tokenizer PHP Extension
XML PHP Extension
```

### Installing

Clone Repository 

```
git clone https://github.com/amang8662/genquiz genquiz
```
Open project
```
cd genquiz
```
Install [Composer](https://getcomposer.org/)
```
composer install
```
Add application key
```
php artisan key:generate
```
Fill data in .env file and run [migrations](https://laravel.com/docs/5.4/migrations)
```
php artisan migrate
```
Run development Server
```
php artisan serve
```
Development URL would be http://localhost:8000

## Additional Info

To use login with facebook and google, add their app id and secret to .env file 

## Built With

* [Laravel 5.4](https://laravel.com/docs/5.4) - The web framework used


## Authors

* **Aman Gupta** - [Amang8662](https://github.com/amang8662)
