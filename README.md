# Laravel Simple Order API

<p>
    <img src="https://media3.giphy.com/media/v1.Y2lkPTc5MGI3NjExd2UxenEzYmdoNjUzd2V5NTM0MTRnNW5pNGI0cjBqN2MzODMxMXE0ZSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/L1R1tvI9svkIWwpVYr/giphy.gif" alt="dish animation" />
</p>

### Available Endpoints

| Method | Endpoint                | Body            | Authorization |
| ------ | ----------------------- | --------------- | ------------- |
| POST   | /api/register           | email, password | None          |
| POST   | /api/login              | email, password | None          |
| POST   | /api/order/{product_id} | quantity        | Bearer Token  |
| GET    | /api/products           | None            | Bearer Token  |
| DELETE | /api/logout             | None            | Bearer Token  |


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
