<h1>ToDoList</h1>
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c1ce60cb-19c6-403e-bd82-145ed9b65a80/big.png)](https://insight.sensiolabs.com/projects/c1ce60cb-19c6-403e-bd82-145ed9b65a80)


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

<h2><a href="/Documentation/Authentication.md">II/How the Authentication works</a></h2>

(For more readability go to the Documentation folder and open the file Authentication.docx)

<h2><a href="/Documentation/Contribute.md">III/How to contribute to the project</a></h2>

(For more readability go to the Documentation folder and open the file Contribute.docx)
