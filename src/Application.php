<?php
declare(strict_types=1);

namespace App;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;


class Application
{
    private $dependencies;

    public function __construct()
    {
        $this->dependencies = new Dependencies();
    }

    public function run()
    {
        $request = Request::createFromGlobals();
        $routes = Routing::getRoutes($this->dependencies);

        $matcher = new UrlMatcher($routes, new RequestContext());

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

        $kernel = new HttpKernel($dispatcher, new ControllerResolver(), new RequestStack(), new ArgumentResolver());

        try {
            $response = $kernel->handle($request);
            $response->headers->set('Content-Type', 'application/json');
        } catch (NotFoundHttpException $e) {
            $response = new Response('Page not found', Response::HTTP_NOT_FOUND);
        }
        catch (\Throwable $e) {
            $response = new Response('Error ' . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $response->send();

        $kernel->terminate($request, $response);
    }
}
