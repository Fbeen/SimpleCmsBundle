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
            'title'     => null,
            'title'     => null,
        ));
    }

    public function renderBlock($identifier)
    {
        $helper = $this->container->get('knp_menu.helper');

        $menu = $helper->get('FbeenSimpleCmsBundle:Builder:cmsMenu', [], array('fbeen_simple_cms_name' => $identifier));

        return $helper->render($menu);
    }
}
