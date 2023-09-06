# Card Switcher API

This is a RESTful API for managing card switching tasks.

## Requirements

* Laravel 10
* PHP 8.1
* MySQL

## Installation

1. Clone the repository.
2. Install the dependencies.

composer install
Configure the database settings in the .env file.
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=card_switcher
DB_USERNAME=root
DB_PASSWORD=
Run the migrations and seeds.
php artisan migrate
php artisan db:seed (to seed merchants in the database)
Start the Laravel development server.
php artisan serve
The API is now running on http://localhost:8000.

## Running API
Make a post request to /api/auth/register  to register a user
{
    "name": "Temitope Soge",
    "email": "soge22.tope@gmail.com",
    "password": "12345678"
}

Make a post request to /api/auth/login  to login
{
    "email": "soge22.tope@gmail.com",
    "password": "12345678"
}

Make a post request to /api/cards  to create a card with your access token as bearer token
{
    "card_number": "123456789",
    "expiration": "06/24",
    "cvv": 345
}

Make a post request to /api/tasks  to create a card switcher tasks with your access token as bearer token
{
    "card_id": "1",
    "merchant_id": "1",
}

Make a put request to /api/tasks/{taskId}/finish  to set a task to finish with your access token as bearer token

Make a put request to /api/tasks/{taskId}/fail  to set a task to failed with your access token as bearer token

Make a get request to /user/{userId}/latest-tasks  to get latest finished task by merchants with your access token as bearer token

Make a get request to /merchants  to get all merchants 

