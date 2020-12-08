# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.8/installation#installation)

Clone the repository

    git clone https://github.com/oneji/easy-way-2go.git

Switch to the repo folder

    cd easy-way-2go

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate
    
Start the database queue driver in order to make Laravel Jobs work as it expected to

    php artisan queue:work
    
**Install supervisor on your machine to be able to property use Laravel Jobs.** Supervisor is a process monitor for the `Linux` operating system, and will automatically restart your `queue:work` process if it fails.

Here's the [Official Documentation](https://laravel.com/docs/8.x/queues#supervisor-configuration) how to install and configure `Supervisor` on `Linux OS`.

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/oneji/easy-way-2go.git
    cd bravos
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:generate
    php artisan queue:work
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

All available seeds are localted in the following directory

    database/seeds/

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

## API Documentation

**You can also find API documentation for this application by the link provided below:**

    https://app.swaggerhub.com/apis-docs/oneji/EuroWay2GO/1.0

----------

# Code overview

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/API` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Mail` - Contains the mail classes
- `app/Http/Jobs` - Contains all the application Jobs
- `app/Http/Requests` - Contains all the admin form requests
- `app/Http/Services` - Contains all the services
- `app/Http/Traits` - Contains all the traits
- `config` - Contains all the application configuration files
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Cross-Origin Resource Sharing (CORS)
 
This applications has CORS enabled by default on all API endpoints. The CORS allowed origins can be changed by setting them in the config file. Please check the following sources to learn more about CORS.
 
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
- https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
- https://www.w3.org/TR/cors