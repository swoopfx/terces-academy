<?php

namespace Admin;

use Authentication\Service\UserService;
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



        // var_dump( $routeMatch->getMatchedRouteName());
        if ($routeMatch->getMatchedRouteName() == "admin" || $routeMatch->getMatchedRouteName() == "admin-process" || $routeMatch->getMatchedRouteName() == "admin-general") {
            if (!$authService->hasIdentity()) {
                $cont->refer = "/admin";
                $response->setStatusCode(301);
                // $referContainer->location = $request->getUriString();
                $controller = $e->getTarget();
                $uri = $request->getUri();
                $fullLink = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());

                $response->getHeaders()->addHeaderLine('Location', $fullLink . "/login");

                // $e->stopPropagation();
            } else {
                $userEntity = $authService->getIdentity();
                if ($userEntity->getRole()->getId() != UserService::USER_ROLE_ADMIN) {
                    $uri = $request->getUri();
                    $fullLink = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
                    // var_dump("JJJJ");
                    // $response->getHeaders()->addHeaderLine('Location', $fullLink . "/logout");
                    $response->getHeaders()->addHeaderLine("Location", $fullLink . "/logout");


                    $response->setStatusCode(302);
                    $response->sendHeaders();

                    exit;
                }
            }
        }
    }
}
