# BarberBook

**BarberBook** is a web-based booking platform designed to manage barber services and appointment scheduling.

## Overview

The project focuses on simplifying appointment management by providing a structured system for customers, services, and bookings.

## Features

* User authentication
* Barber/service management
* Appointment booking
* Booking management
* Database-driven application
* Server-side validation
* Responsive user interface
* MVC-based architecture

## Technology Stack

* **Backend:** PHP, Laravel
* **Frontend:** HTML, CSS, JavaScript
* **Database:** MySQL
* **Architecture:** MVC

## Installation

Clone the repository:

```bash
git clone https://github.com/MREZA-MJDi/BarberBook.git
cd BarberBook
```

Install dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database in `.env`.

Run migrations:

```bash
php artisan migrate
```

Start the application:

```bash
php artisan serve
```

## Architecture

The application follows the MVC pattern provided by Laravel.

The main application layers include:

* Models
* Controllers
* Views
* Routes
* Database migrations
* Validation

This structure keeps business logic organized and makes the application easier to maintain and extend.

## Development Focus

BarberBook was developed as a practical project for implementing real-world booking workflows, database relationships, validation, and server-side application logic.

## Author

**Mohammad Reza Majidi**

Full-Stack Web Developer

GitHub: [MREZA-MJDi](https://github.com/MREZA-MJDi)
