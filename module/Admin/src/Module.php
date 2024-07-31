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
        $adminMenu = new Container("admin_menu");
        $adminMenu->isMenu = " ";



        // var_dump( $routeMatch->getMatchedRouteName());
        if ($routeMatch->getMatchedRouteName() == "admin" || $routeMatch->getMatchedRouteName() == "admin-process" || $routeMatch->getMatchedRouteName() == "admin-general") {
            $adminMenu->isMenu = "admin";
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
                if ($userEntity->getRole()->getId() < UserService::USER_ROLE_ORACLE_P6) {
                    $uri = $request->getUri();
                    $fullLink = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
                    // var_dump("JJJJ");
                    // $response->getHeaders()->addHeaderLine('Location', $fullLink . "/logout");
                    $response->getHeaders()->addHeaderLine("Location", $fullLink . "/logout");


                    $response->setStatusCode(302);
                    $response->sendHeaders();

                    exit;
                } else if ($userEntity->getRole()->getId() == UserService::USER_ROLE_ORACLE_P6) {
                    $adminMenu->isMenu = "p6";
                } else {
                    $adminMenu->isMenu = "admin";
                }
            }
        }
    }
}
