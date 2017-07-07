<?php

namespace front;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class Provider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $route = $app['controllers_factory'];

        $route->get('/', "front\Provider::index")->bind('homepage');

        return $route;
    }

    public function index(Application $app)
    {
    	return $app['twig']->render("index.html.twig", []);
    }
}
