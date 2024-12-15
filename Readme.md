1. Cloner le projet
2. Aller dans le projet ./my-symfony-project
3. Dans un Terminal, exécuter les commandes : 
    symfony server:start
    php bin/console make:migration                   
    php bin/console doctrine:migrations:migrate
4. Ouvrir dans un navigateur : http://localhost:8000/
5. Créer un User avec pour username "root" pour créer/supprimer les articles
6. Les articles se créent à partir d'un titre et une image

Au préalable, il faut avoir :
composer
php 8.1 ou +
Extensions php : pdo_mysql, mbstring, xml, intl.
symfony

Pour les dépendances :
composer require doctrine/doctrine-bundle
composer require doctrine/migrations
composer require symfony/framework-bundle
composer require symfony/monolog-bundle
composer require symfony/security-bundle
composer require symfony/ux-stimulus
composer require symfony/ux-turbo
composer require twig
composer require twig/extra-bundle

composer require --dev symfony/debug-bundle
composer require --dev symfony/maker-bundle
composer require --dev symfony/web-profiler-bundle

Si quelconque problème -> dev02@sportyneo.com