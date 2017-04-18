Blog Visits Tracker
========================

Blog visits tracker application based on the Symfony Standard Edition.


Initialize
--------------

Open your terminal and run the following lines:

```
$ git clone https://github.com/alexhoma/mpwar-frameworks-project-v2.git
$ composer update
$ php bin/console doctrine:schema:create
```
<br>
Include the following twig view (it's a JS snippet) on the post template view of your blog: (It's included by default on this example)

```
{% include("TrackerBundle:Tracker:tracker.html.twig") %}
```

Then go to `http://{LOCALHOST}:{PORT}/web/app_dev.php/blog` in dev environment.

Context
--------------
  * **BlogBundle** - This is supposed to be part of the original application, soit's a very simple blog example to test our TrackerBundle.<br>
  Here you can create posts, list and read them (not delete or update).<br>
  It only has one entity called `Post`.
    
  * **TrackerBundle** - This is our visits tracker.<br>
    It takes the User Agent via javascript and saves it to our application.<br>
    It comes with a single Entity `Record` related to the blog's `Post`.<br>
    In the dashboard were we can see:
      * All recorded visits in our blog.
      * A detail view of every record/visit (User agent stuff)
      * And how many records/visits a single post has had.
      
    I know this could be achieved in a more efficient way using something like this `$request->headers->get('User-Agent')` and parsing it. But it was just an excuse to start this exercise and also play with AJAX requests.
    
  * **AlertBundle** - This bundle tells us if we have achieved a certain number of visits in our posts, sending an email with the info via SwiftMailer.<br>
  It has a listener triggered just after a record/visit is saved on the database.<br>
  By default we will receive an email every 10, 50 and 100 visits of each post.
  
  ### Page examples
  To see some screenshots of the application refer to the previous exercise readme: [mpwar-frameworks-project](https://github.com/alexhoma/mpwar-frameworks-project)


Changelog
--------------
  * Clean unused code and format code style.
  * Document better methods and classes.
  * Type casting
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
Just email me: [alexcm.14@gmail.com](alexcm.14@gmail.com)

