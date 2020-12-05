# Contacts

## Installation
-   Run `composer install`
-   Copy `.env.example` to `.env` and enter your database credentials
-   Run `php artisan key:generate`
-   Run `php artisan migrate:fresh --seed`
-   Run `php artisan make:user {email}` to generate yourself a new user
-   Run `npm install && npm run prod` to generate missing styles
-   Create a `contacts_testing` database, or change the value of the database in `phpunit.xml`

## Attribution

TailwindCSS & Open source Tailwind UI components were used to scaffold the front end.
