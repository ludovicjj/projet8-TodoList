#ToDoList

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6cd8ea55552f4262b65260c83bf18313)](https://www.codacy.com/app/ludovicjj/projet8-TodoList?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ludovicjj/projet8-TodoList&amp;utm_campaign=Badge_Grade)

##Context
Improve an an existing project :

* [ToDoList](https://openclassrooms.com/projects/ameliorer-un-projet-existant-1)

## Project using
* PHP 7.2
* Symfony 3.4
* Doctrine
* Behat

## How to instal
1.  Download project :

        https://github.com/ludovicjj/projet8-TodoList.git

2.  Install Dependencies :

        composer install

3.  Database config :

    Update file parameters.yml.dist with your config and rename it into "parameters.yml"

        parameters:
            database_host:     127.0.0.1
            database_port:     ~
            database_name:     symfony
            database_user:     root
            database_password: ~

4.  Create Database :
   
        php bin/console doctrine:datase:create
        php bin/console doctrine:schema:update --force

5.  Fixtures :

        php bin/console doctrine:fixtures:load

6.  Project launch :

        php bin/console server:run

## How to use
* First, run project with the following command and go to ^/login

        php bin/console server:run

* Use these credentials to test admin features :

        username: admin
        password: admin

* Or use these credentials to test user features :

        username: user1
        password: user1

## Test
1.  Create database for the test env with the following command :

        php bin/console doctrine:database:create --env=test

2.  Run test with the following command :

        vendor/bin/behat

3.  Code-coverage