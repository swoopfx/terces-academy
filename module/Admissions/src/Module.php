<?php

namespace Admissions;

use General\Service\GeneralService;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $eventManager = $application->getEventManager();
        $eventManager->attach("route", [$this, 'onRoute'], -100);
    }


    public function onRoute(MvcEvent $e)
    {
        $application = $e->getApplication();
        $routeMatch = $e->getRouteMatch();
        $sm = $application->getServiceManager(); // service Manager
        $generalService = $sm->get(GeneralService::class);
        $response = $e->getResponse();
        $request = $e->getRequest();
        $authService = $generalService->getAuth();
        $cont = new Container("refer");

        $controller = $routeMatch->getParam("controller");
        $action = $routeMatch->getParam("action");
        $interface = $routeMatch->getParam("interface");

        // var_dump($action);
        // var_dump($routeMatch->getMatchedRouteName());

        // var_dump( $routeMatch->getMatchedRouteName());
        if ($routeMatch->getMatchedRouteName() == "admissions" || $routeMatch->getMatchedRouteName() == "portal" || $routeMatch->getMatchedRouteName() == "sendmoney") {
            if ($routeMatch->getMatchedRouteName() == "admissions" &&  $action == "intent") {
                // var_dump("HERE");
            }
            else {
                if (!$authService->hasIdentity()) {
                    $cont->refer = "/admissions";
                    $response->setStatusCode(301);
                    // $referContainer->location = $request->getUriString();
                    $controller = $e->getTarget();
                    $uri = $request->getUri();
                    $fullLink = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());

                    $response->getHeaders()->addHeaderLine('Location', $fullLink . "/login");

                    // $e->stopPropagation();
                }
            }
        }
    }
}
