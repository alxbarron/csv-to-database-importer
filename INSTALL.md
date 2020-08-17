# Contact List CSV Importer

> ### CSV files Importer with map fields API made with Laravel 7.24 & Vue 2.5.17

----------

# Getting started

## Installation

Please check the official Laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/7.x)


Clone the repository

    git clone https://github.com/alxbastard/csv-to-database-importer

Switch to the repo folder

    cd csv-to-database-importer

Install all the Laravel dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key & set it on .env file

    Typically, this string should be 32 characters long

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Set the version of node used on this project

    nvm install

Install all the vue dependencies using composer

    npm install

Run the task for transpiling javascript & sass

    npm run dev
    or
    npm run watch

Start the local development server

    php -S localhost:8000 -t public

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/alxbastard/csv-to-database-importer
    cd csv-to-database-importer
    composer install
    cp .env.example .env
    Set 32 chars application key on .env file
    php artisan migrate

    nvm install
    npm install
    npm run dev

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php -S localhost:8000 -t public

## Database seeding

**Populate the database with seed data. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database and seed by running the following command

    php artisan migrate:refresh --seed
