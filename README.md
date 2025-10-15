# Laravel Profile API - HNG stage 0 task

This is a simple Laravel 12 API project exposing a `GET /me` endpoint that returns user profile data, current timestamp, and a fresh cat fact fetched from an external API.

## Features

- GET /me endpoint with rate limiting (30 requests/minute)
- Returns JSON with user info, UTC ISO 8601 timestamp, and cat fact.
- Fetches new cat fact on every request (no caching).
- Handles external API errors gracefully.
- Basic logging for debugging.
- PHPUnit test covering the endpoint.

***

## Local Setup Instructions (Windows with LAMP Stack)

### Prerequisites

- **PHP 8.2+**: Download and install from [php.net](https://windows.php.net/download)
- **Composer**: Install from [getcomposer.org](https://getcomposer.org/download/)
- **Apache & MySQL**: Use WAMP/XAMPP or any LAMP stack on Windows.
- **Git** (optional): To clone this repo
- **Postman** (optional): For API testing and import docs

### Steps

1. **Clone or create Laravel app**

   Navigate your Apache `htdocs` directory (e.g., `C:\xampp\htdocs`), then either clone or create a new Laravel project:

   ```bash
   cd C:\xampp\htdocs
   laravel new app-name
   cd app-name
   ```

2. **Copy controller and route**

   - Place `ProfileController.php` in `app/Http/Controllers/`
   - Define the route in `routes/api.php`:

   ```php
   use App\Http\Controllers\ProfileController;

   Route::middleware('throttle:30,1')
        ->get('me', [ProfileController::class, 'myProfile'])
        ->name('profile');
   ```

3. **Environment Setup**

   Your app does not require a database. Set `.env` with:

   ```
   DB_CONNECTION=sqlite
   DB_DATABASE=:memory:
   CACHE_DRIVER=file
   SESSION_DRIVER=file
   ```

4. **Install dependencies**

   Run composer install:

   ```
   composer install
   ```

5. **Serve your Laravel app**

   You can serve using artisan or configure Apache:

   ```bash
   php artisan serve
   ```

   Visit [http://localhost:8000/api/me](http://localhost:8000/api/me)

6. **Run PHPUnit Tests**

   Run all tests via artisan:

   ```
   php artisan test
   ```

***

## Dependencies

- PHP 8.2+
- Laravel 12.x
- Composer packages (official Laravel dependencies)
- Guzzle HTTP Client (comes included with Laravel for making HTTP requests)
- PHPUnit (for tests, included via composer)

***

## Postman Documentation

Import the API docs via this Postman link:

[https://documenter.getpostman.com/view/29651789/2sB3QNp8Wb](https://documenter.getpostman.com/view/29651789/2sB3QNp8Wb)

This includes the `/me` endpoint with sample responses for easy testing.

***

## Additional Notes

- Make sure `storage/logs` is writable for logging.
- Rate limiting is set to 30 requests per minute via middleware.
- CORS is set up to allow from all origins.
- This project runs without a real database connection by using SQLite in-memory.
