<?php

namespace Fbeen\SimpleCmsBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface; 
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Fbeen\SimpleCmsBundle\Entity\Content;

/**
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */
class RouteHelper
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function getFilteredRouteList()
    {
        $allRoutes = $this->container->get('router')->getRouteCollection()->all();
        
        foreach($allRoutes as $route => $params)
        {
            if($this->validateRoute($route))
            {
                $routes[$route] = $route;
            }
        }
        
        return $routes;
    }
    
    private function validateRoute($route)
    {
        $filters = $this->container->getParameter('fbeen_simple_cms.route_filters');

        foreach($filters as $filter)
        {
            if(strncmp($filter, $route, strlen($filter)) == 0)
                return false;
        }
        
        return true;
    }
}
