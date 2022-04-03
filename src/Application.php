<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class Application
 */
class Application
{
    /**
     * @var \DI\Container
     */
    private $container;

    /**
     * Receives compiled di container
     *
     * @param \App\Bootstrap $bootstrap
     */
    public function __construct(Bootstrap $bootstrap)
    {
        $this->container = $bootstrap->getDi();
    }

    /**
     * Application initialization
     */
    public function run(): void
    {
        $request = Request::createFromGlobals();
        $context = (new RequestContext())->fromRequest($request);

        $this->handleRequest($request, $context)->send();
    }

    /**
     * Tries to get response for passed request
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Routing\RequestContext $context
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    protected function handleRequest(Request $request, RequestContext $context): Response
    {
        try {
            $matcher = new UrlMatcher($this->getRoutes(), $context);
            $parameters = $matcher->match($context->getPathInfo());
            $controller = $this->resolveController($parameters['_controller']);

            return $controller($request);
        } catch (ResourceNotFoundException $e) {
            return new JsonResponse([], Response::HTTP_NOT_IMPLEMENTED);
        } catch (MethodNotAllowedException $e) {
            return new JsonResponse(['allowedMethods' => $e->getAllowedMethods()], Response::HTTP_METHOD_NOT_ALLOWED);
        } catch (\Throwable $e) {
            $this->container->get('logger')->error('Unhandled exception', ['message' => $e->getMessage()]);

            return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Transforms routes file to RouteCollection
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    protected function getRoutes(): RouteCollection
    {
        $fileLocator = new FileLocator([ROOT_DIR . '/config/routes']);

        return (new YamlFileLoader($fileLocator))->load('routes.yaml');
    }

    /**
     * Resolves controller action
     *
     * @param string $controller
     * @return callable
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    protected function resolveController(string $controller): callable
    {
        if (str_contains($controller, '::')) {
            [$class, $method] = explode('::', $controller);

            return [$this->container->get($class), $method];
        }

        return $this->container->get($controller);
    }
}
