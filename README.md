# Order Management System- Matat

> ### Order Management System that fetches Orders from WooCommerce and syncs in application database and retrieves their list. 

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x/installation)

Clone the repository

    git clone git@github.com:bsudip99/oms-matat.git

Switch to the repo folder

    cd oms-matat

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:bsudip99/oms-matat.git
    cd oms-matat
    composer install
    cp .env.example .env
    php artisan key:generate 
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    
The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).
----------

# Code overview

## Dependencies

- [jwt-auth](https://github.com/tymondesigns/jwt-auth) - For authentication using JSON Web Tokens
- [laravel-cors](https://github.com/barryvdh/laravel-cors) - For handling Cross-Origin Resource Sharing (CORS)

## Folders

- `app/Models` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the api controllers with versioning (currently using v1 )
- `app/Http/Middleware` - Contains the middleware
- `app/Http/Resources` - Contains the resource class used for formatting resource sent via API
- `app/Repositories` - Contains repository classes for communicating with model class
- `app/Services` - Contains Service classes for business logic and communication with repositories classes.
- `app/Helpers` - Contains helper class like GeneralHelper for listing helper(utils) functions
- `app/Constants` - Contains constants files used in all section of application
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests
- `tests/Feature/Api` - Contains all the api tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api/v1/

----------
# Routes 
Get Order API

    http://localhost:8000/api/v1/orders

Search in Order API by number, order_key, customer_note

    http://localhost:8000/api/v1/orders?search={query}
 Sorting in Order API by any field in order table (sortDirection as either asc or desc)
    
    http://localhost:8000/api/v1/orders?sortBy={fieldName}&sortDirection={asc}
 
 Filter by status
    
    http://localhost:8000/api/v1/orders?status={status}
    
 Filter between date_created (can be toggled between any of the following)
 
    http://localhost:8000/api/v1/orders?startDate={YYYY-MM-DD}
    http://localhost:8000/api/v1/orders?endDate={YYYY-MM-DD}
    http://localhost:8000/api/v1/orders?startDate={YYYY-MM-DD}&endDate={YYYY-MM-DD}
 
 Pagination
 
    http://localhost:8000/api/v1/orders?per_page={number}&page={number}

 Sync Order API 
    
    http://localhost:8000/api/v1/orders/syncOrder