Blog Visits Tracker
========================

Blog visits tracker application based on the Symfony Standard Edition.


Initialize
--------------

Open your terminal and run the following:

```
$ git clone https://github.com/alexhoma/mpwar-frameworks-project-v2.git
$ composer update
$ php bin/console doctrine:schema:create
```

Include the following snippet on your post view template: (is included by default on this example)

```
{% include("TrackerBundle:Tracker:tracker.html.twig") %}
```

Then go to: (dev environment)
```
http://{LOCALHOST}:{PORT}/web/app_dev.php/blog
```


Context
--------------
  * **BlogBundle** <br>
    This is supposed to be the original application, so it's a very simple blog example to test our TrackerBundle.<br>
    Composed by one entity called `Post`.<br>
    The bundle comes with two sections:
      * **Admin**: where you can create new posts, edit, and list all of them.
      * **Blog**: where you can list only published posts and read them.
       
    The admin section could be in an AdminBundle, but I just wanted to keep things simple.
    
  * **TrackerBundle** <br> 
    This is our visits tracker. It takes the User Agent via javascript and saves it to our database.<br>
    Composed by a single Entity `Record` related to the blog's `Post`.<br>
    It comes with a dashboard were we can see:
      * All recorded visits in our blog.
      * A detail view of every record/visit (User agent stuff)
      * And how many records/visits a single post has had.
      
    This could be achieved in a more efficient way using something like this `$request->headers->get('User-Agent')` and parsing it. But it was just an excuse to start this exercise and also play with AJAX requests.
    
  * **AlertBundle** <br> 
  This bundle tells us if we have reached a certain number of visits in our posts, sending an email with the info via SwiftMailer.<br>
  It has a listener triggered just after a record/visit is saved on the database.<br>
  By default we will receive an email every 10, 50 and 100 visits of each post.
  
  ### Page examples
  To see some screenshots of the application refer to the previous exercise readme: [mpwar-frameworks-project](https://github.com/alexhoma/mpwar-frameworks-project#pages)


Changelog 
-------------
Improved things since the first version:
  * Clean unused code and format code style.
  * Document better methods and classes.
  * Add an admin page to the Blog Bundle, so you can edit posts.
  * Type hinting (I'm running PHP7, so I omitted PHP7.1 type hinting intentionally)
  * Rename non semantic variables and constants, specially `$em`, this one sucks!
  * Move form creations outside the Controller, as a FormTypes.
  * Validate form on submit `$this->isValid()`, I forgot to add it on the previous exercise.
  * Inject dependencies like "slugify" as a service thru the service container.
  * Map Entities to the Doctrine ORM using Yaml files, avoiding annotations.
  * Move business logic as a services, using the service container.
  * Make custom repository classes.
  * Use Factory service to avoid requiring only the Doctrine Entity Manager in every repository.
  * Use Dependency Inversion Principle to abstract our database queries.
  * Remove unused code, unnecessary comments and empty directories.

Docs
---------------
  * Symfony docs in general
  * Twig docs in general
  * Doctrine docs
    * [Mapping](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/association-mapping.html)
    * [Custom repositories](http://docs.doctrine-project.org/en/latest/reference/working-with-objects.html#custom-repositories)
    * [Factories to require services](http://docs.doctrine-project.org/en/latest/reference/working-with-objects.html#custom-repositories)
  * Other
    * [inject-a-repository-instead-of-an-entity-manager](https://php-and-symfony.matthiasnoback.nl/2014/05/inject-a-repository-instead-of-an-entity-manager/)


Support
---------------
Just email me [alexcm.14@gmail.com](alexcm.14@gmail.com) :P

