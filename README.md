# Laravel Simple Order API

## `composer install`

install all dependencies

### `copy .env.example and rename it to .env and configure .env file`

you can select whatever database you want as long as SQL. I used PostgreSQL.

## `php artisan key:generate`

to generate .env APP_KEY

## `php artisan migrate --seed`

to migrate and seed database and testing database connection

## `php artisan test`

to start http test for all routes

## `php artisan serve`

to start the server on http://127.0.0.1:8000

# Available Endpoints

| Method | Endpoint                | Body            | Authorization |
| ------ | ----------------------- | --------------- | ------------- |
| POST   | /api/register           | email, password | None          |
| POST   | /api/login              | email, password | None          |
| POST   | /api/order/{product_id} | quantity        | Bearer Token  |
| GET    | /api/products           | None            | Bearer Token  |
| DELETE | /api/logout             | None            | Bearer Token  |
