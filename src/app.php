<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmExtension;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Rpodwika\Silex\YamlConfigServiceProvider;

define("APP_ROOT", __DIR__ . "/");
define('CONF_FILES', __DIR__ . "/../config/");

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());

// database
$app->register(new YamlConfigServiceProvider(CONF_FILES . "database.yml"));
$app->register(new DoctrineServiceProvider(), ["db.options" => $app["config"]["database"]]);
$db_config = Setup::createAnnotationMetadataConfiguration([APP_ROOT . "models"], $app["debug"]);
$app["orm.em"] = EntityManager::create($app["db"], $db_config);

// twig
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...
	$twig->addExtension(new Twig_Extensions_Extension_Text());

    return $twig;
});

return $app;
