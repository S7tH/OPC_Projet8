<h1>ToDoList</h1>
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c1ce60cb-19c6-403e-bd82-145ed9b65a80/small.png)](https://insight.sensiolabs.com/projects/c1ce60cb-19c6-403e-bd82-145ed9b65a80)


How to use it :

<h2>I/Installation</h2>

After copied (clone or download) this repository github on your computer

    1.Adapt your data base parameters in the following folder : "app/config/parameters.yml"

    -use the commande php composer.phar install to create the vendor
    composer download address:
    https://getcomposer.org/download/

    2.Create your Database with the following command :
    -"php bin/console doctrine:database:create"

    3.Generate your tables :
    -"php bin/console doctrine:schema:update --force

    4.put assets in rights folders by using (in prompt)
    - php bin/console assets/install

<h2><a href="/Documentation/Authentication.md">II/How works the Authentication</a></h2>


<H2>III/How to contribute to that project</H2>

To contribute to this project, please respect the following steps:

1) fork the repository on your github account

2) create a new branch ( /!\ don't use the master and dev branch, if not your aske to a pull request will be ignored)

3) Check your repository github with this following tool a first time :(https://insight.sensiolabs.com/)

4) create your features and your Phpunit tests, while respecting code conventions (PSR).

For learn to make the php unitary test:
https://openclassrooms.com/courses/testez-et-suivez-l-etat-de-votre-application-php

For learn to make the php fonctional test:
https://openclassrooms.com/courses/testez-fonctionnellement-votre-application-symfony


5) Check your repository github with this following tool a second time :(https://insight.sensiolabs.com/)
If there are new errors created by you, try to fix at less the criticals and major errors. Minor errors should be good to fix too if possible.

6) Open an issue or a pull request to suggest changes or additions check up if your suggest don't already exist in our issues.

7) If your suggest is checked then validated, so create a pull request to this repository 


Contributors :
 - Sarah KHALIL
 - Aurélien THERIOT
