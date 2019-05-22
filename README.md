zood
====
#### Check out the project
$ git clone https://github.com/orodsem/zood.git

#### Run symfony server
$ php bin/console server:run

#### Run the API
Endpoint: http://localhost:8000/provider

Method: GET

#### Create a new bundle
$ php bin/console generate:bundle

Then make sure to update composer.json and add the new bundle

$ composer dump-autoload 

#### Create a new entity
$ php bin/console generate:doctrine:entity

The Entity shortcut name: [BundleName]:[EntityName]

Example: ProviderBundle:Provider

#### Check entities correctly mapped
$ php bin/console doctrine:mapping:info

#### Update database
$ php bin/console doctrine:schema:update --force  

#### See all the routs
$ php bin/console debug:router
