<?php

namespace Fbeen\SimpleCmsBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function cmsMenu(FactoryInterface $factory, array $options)
    {
        $menuName = $options['fbeen_simple_cms_name'];

        $knpMenu = $factory->createItem($menuName);

        $knpMenu = $this->buildMenu($menuName, $knpMenu);

        return $knpMenu;
    }
    
    private function buildMenu($menuName, $knpMenu)
    {
        $em = $this->container->get('doctrine')->getManager();
        
        $menu = $em->getRepository('FbeenSimpleCmsBundle:Menu')->findMenu($menuName);
        if(NULL === $menu)
        {
            throw new NotFoundHttpException('The menu "'.$menuName.'" does not exist. Create a menu with this name in the admin or change the name in the template.');
        }
        
        $knpMenu->setChildrenAttribute('class', $menu->getClass());
        
        foreach($menu->getMenuitems() as $menuitem)
        {
            switch($menuitem->getType())
            {
                case 'route':
                    try {
                        $knpMenu->addChild($menuitem->getLabel(), array('route' => $menuitem->getValue()));
                    } catch (\Symfony\Component\Routing\Exception\RouteNotFoundException $ex) {
                        $knpMenu->addChild($menuitem->getLabel())
                            ->setLabelAttribute('title', 'The route "' . $menuitem->getValue() . '" does not exist.'); // make a span instead
                    }
                    break;
            
                case 'url':
                    $knpMenu->addChild($menuitem->getLabel(), array('uri' => $menuitem->getValue()));
                    break;
            
                case 'submenu':
                    $knpMenu->addChild($menuitem->getLabel(), array('uri' => '#'));
                    $this->buildMenu($menuitem->getValue(), $knpMenu[$menuitem->getLabel()]);
                    if($this->container->getParameter('fbeen_simple_cms.bootstrap_menus'))
                    {
                        $knpMenu[$menuitem->getLabel()]->setChildrenAttributes(array('class' => 'dropdown-menu'));
                        $knpMenu[$menuitem->getLabel()]->setLinkAttributes(array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'role' => 'button', 'aria-haspopup' => 'true', 'aria-expanded' => 'false'));
                    }
                    break;
            
                default:
            }

            $knpMenu[$menuitem->getLabel()]->setAttribute('class', $menuitem->getLiClass());
            $knpMenu[$menuitem->getLabel()]->setLinkAttribute('class', $menuitem->getAClass());
        }
        
        return $knpMenu;
    }
}