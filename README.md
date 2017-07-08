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
    
*Tip: [MailTrap](mailtrap.io) is a good option to fake a SMTP server.*
    

### 2. Set database
The following commands will create a new database, update it with the application's tables and load initial data to it.

    bin/console doctrine:database:create
    bin/console doctrine:migrations:migrate
    
### 3. Load initial data
    bin/console doctrine:fixtures:load
    
### 4. Run the application using the built-in server
    bin/console server:run
    
**Credentials to secured area:** 

*Username:* lengoo  
*Password:* lengoo
    
The console will show the correct address where the application will be available.

## Testing
To run the tests just run the following command at the project's root directory:
    
    vendor/bin/phpunit
    