# Rodrigo's Symfony Test

This application was developed following [these instructions](https://github.com/lengoo/SymfonyTest-Rodrigo/app/Resources/doc/README.md) in order to show my skills on web development using **Symfony Framework**.

## Requirements
- PHP 7
- MySQL
- Active Internet connection

## Instructions

### 1. Install the project dependencies
You have to specify a valid email settings and your database parameters.

    composer install
    

### 2. Set database
The following commands will create a new database, update it with the application's tables and load initial data to it.

    bin/console doctrine:create:database
    bin/console doctrine:schema:update --force
    bin/console doctrine:fixtures:load
    
### 3. Run the application using the built-in server
    bin/console server:run
    
The console will show the correct address where the application will be available to be used.