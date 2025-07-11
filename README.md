# Simple Dashboard

A simple project to practice Laravel and Inertia.js.

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 22.x

## Installation

1. Clone the repository
2. `cd` into the project directory
3. Install php dependencies `composer install`
4. Copy `.env.example` to `.env`
5. Generate project key `php artisan key:generate`
6. Run migrations `php artisan migrate`
7. Create storage link `php artisan storage:link`
8. Run database seeders `php artisan db:seed`
8. Install npm dependencies `npm install`

## Running the project

1. Run `php artisan serve` to start the local server
2. Run `npm run dev` or `npm run build` to hot-reload or build the assets
3. Open `http://localhost:8000` in your browser
4. User `test@example.com` and `password` to login
5. The above user is created by the database seeders

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

#### This project is still under development. Please do not use it in production.
