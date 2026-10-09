# BarberBook

BarberBook is a Laravel-based appointment-booking application focused on barbershops. The codebase includes booking-oriented application structure and uses QR-code generation and Jalali date support. Check the current routes and tests for the exact workflows available in the checked-out version.

## Stack
- PHP `^8.2`, Laravel `^12.0`
- Blade and Vite-based frontend assets
- Database configured through Laravel's `.env`
- QR code generation: `chillerlan/php-qrcode`
- Jalali dates: `morilog/jalali`
- PHPUnit-based tests

## Requirements
PHP 8.2+, Composer, Node.js/npm, and MySQL/MariaDB or another Laravel-supported database.

## Install locally
```bash
git clone https://github.com/MREZA-MJDi/BarberBook.git
cd BarberBook
composer install
```

Copy `.env.example` to `.env` (`copy .env.example .env` in Windows CMD; `cp .env.example .env` on macOS/Linux). Create a local database and set `DB_*` values in `.env`.

```bash
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

Visit `http://127.0.0.1:8000` unless Artisan reports a different address. During frontend work, use `npm run dev` in another terminal.

## Run tests
```bash
php artisan test
```

## Important
No production credentials or default administrator password should be inferred from this documentation. Inspect available seeders and environment configuration before attempting to create demo data. Do not run destructive database reset commands on a database you need to preserve.

## Links
- Repository: https://github.com/MREZA-MJDi/BarberBook
- Laravel documentation: https://laravel.com/docs/12.x
