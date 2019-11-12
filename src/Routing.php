<?php
declare(strict_types=1);

namespace App;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Routing
{

    public static function getRoutes(Dependencies $dependencies): RouteCollection
    {
        $routes = new RouteCollection();
        $routes->add('getUser',
            new Route(
                '/users/{userId}',
                [ '_controller' => [$dependencies->get('userController'), 'get']],
                [],
                [],
                null,
                [],
                ['GET']
            ));
        $routes->add('listUsers',
            new Route(
                '/users/',
                [ '_controller' => [$dependencies->get('userController'), 'list']],
                [],
                [],
                null,
                [],
                ['GET']
            ));

        $routes->add('postUser',
            new Route(
                '/users/',
                [ '_controller' => [$dependencies->get('userController'), 'post']],
                [],
                [],
                null,
                [],
                ['POST']
            ));

        $routes->add('putUser',
            new Route(
                '/users/',
                [ '_controller' => [$dependencies->get('userController'), 'put']],
                [],
                [],
                null,
                [],
                ['PUT']
            ));

        $routes->add('deleteUser',
            new Route(
                '/users/{userId}',
                [ '_controller' => [$dependencies->get('userController'), 'delete']],
                [],
                [],
                null,
                [],
                ['DELETE']
            ));

        return $routes;
    }
}
