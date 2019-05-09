# Contributing

If you want improve this project or add new feature please follow the following instructions

Don't forget to check your code with PSR-1 and PSR-2

```
vendor/bin/phpcs
```

And provide test with your patch

## Instruction

1.  fork project 

        git clone https://github.com/ludovicjj/projet8-TodoList.git

2.  Create your feature branch

        git checkout -b my-new-feature

3.  Commit your change
    
        git commit -am 'Add some feature'

4.  Push to the branch

        git push origin my-new-feature
        
5.  Create new Pull Request

## Test

1.  Create database for the test env with the following command :

        php bin/console doctrine:database:create --env=test

2.  Run test with the following command :

        vendor/bin/behat

3.  Behat-code-covarge require Xdebug, download Xdebug and enable it in php.ini. Code-coverage will be generated in var/behat-coverage, open with your browser var/behat-coverage/index.html
