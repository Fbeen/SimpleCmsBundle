<?php

namespace Fbeen\SimpleCmsBundle\Routing;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class SimpleCmsLoader extends Loader
{
    private $loaded = false;

    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not run the SimpleCms routeloader twice');
        }

        $routeCollection = new RouteCollection();
        
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        
        $routes = $em->getRepository('FbeenSimpleCmsBundle:Route')->findAllEnabled();

        if(NULL !== $routes)
        {
            foreach($routes as $route)
            {
                $controller = $this->container->getParameter('fbeen_simple_cms.default_controller');
                
                if($route->getController())
                {
                    $controller = $route->getController();
                }

                $defaults = array(
                    '_controller' => $controller,
                );

                $newRoute = new Route($route->getRoute(), $defaults);
                $routeCollection->add($route->getName(), $newRoute);
            }
        }

        $this->loaded = true;

        return $routeCollection;
    }

    public function supports($resource, $type = null)
    {
        return 'fbeen_simple_cms' === $type;
    }
}