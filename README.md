MNPHP 04/16 - Decouple from the framework
=================

This repo contains code samples I used in a presentation about how to decouple domain classes and business logic from frameworks using SOLID principles and some Domain Driven Design aspects.

The presentation was given for the MNPHP usergroup in April 2016

###Slides
https://speakerdeck.com/aminemat/mnphp-decouple-from-the-framework

###Recording
https://www.youtube.com/watch?v=V1OE_wiE0LE


###Setup
#### Install dependencies
```composer install```

#### Create database
```bin/console doctrine:database:create```

#### Create schema
```bin/console doctrine:schema:create```

#### Populate database with fixtures (optional)
``` bin/console hautelook_alice:doctrine:fixtures:load ```


##Running tests

#### Unit tests
``` bin/phpunit ```

#### Integration tests
``` bin/behat ```
