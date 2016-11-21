<?php

namespace Fbeen\SimpleCmsBundle\Blocks;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Fbeen\SimpleCmsBundle\Model\BlockInterface;
use Knp\Menu\Twig\Helper;

/**
 * Description of MenuBlock
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */

class MenuBlock extends AbstractBlock
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template'  => 'FbeenSimpleCmsBundle:Blocks:menu_block.html.twig',
            'class' => 'menublock',
            'title'     => null,
        ));
    }

    public function renderBlock($identifier)
    {
        $helper = $this->container->get('knp_menu.helper');

        $menu = $helper->get('FbeenSimpleCmsBundle:Builder:cmsMenu', [], array('fbeen_simple_cms_name' => $identifier));
        $menu = $helper->render($menu);
        
        return $this->container->get('twig')->render($this->options['template'], array(
            'menuBlock' => array(
                'class' => $this->options['class'],
                'title' => $this->options['title'],
                'menu' => $menu
            )
        ));
    }
}
