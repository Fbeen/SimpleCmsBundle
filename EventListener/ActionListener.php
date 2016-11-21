<?php
namespace Fbeen\SimpleCmsBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class ActionListener extends ResponseListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelRequest(FilterControllerArgumentsEvent $event)
    {

        $em = $this->container->get('doctrine.orm.default_entity_manager');
        
        /*
         * Not all routes are cms routes. We will load the content only if it is a cms route.
         */
        $route = $em->getRepository('FbeenSimpleCmsBundle:Route')->findRouteWithCompleteContent($event->getRequest()->get('_route'));

        if(NULL !== $route)
        {
            //$event->getRequest()->attributes->set('contentDocument', $route->getContent());
            $this->container->get('fbeen.simple_cms.content_helper')->setContent($route->getContent());
        }
    }
}
