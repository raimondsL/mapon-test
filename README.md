# Mapon Test

## Setup

The application should set up a scheduled job to get data from mapon endpoint.

> 1) Copy .env.example file and set up `APP_KEY` and `MAPON_ENDPOINT`, `MAPON_KEY` variables.

> 2) `composer install`, `npm install`, `npm run dev/prod`, `php artisan migrate`

> 3) [Running The Scheduler](https://laravel.com/docs/8.x/scheduling#running-the-scheduler) add Laravel scheduler to your environment.
> ```
> * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
> ```
> or run the command manually for testing purposes ```php artisan schedule:run```

> 4) Serve or run the application (apache/nginx).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
