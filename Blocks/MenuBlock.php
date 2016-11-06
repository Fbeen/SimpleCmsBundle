<?php

namespace Fbeen\SimpleCmsBundle\Blocks;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Fbeen\SimpleCmsBundle\Model\BlockInterface;
use Knp\Menu\Twig\Helper;

/**
 * Description of MenuBlock
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */

class MenuBlock implements BlockInterface
{
    private $helper;

    /**
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function renderBlock($identifier, $options = array())
    {
        $options = array_merge($options, array('fbeen_simple_cms_name' => $identifier));

        $menu = $this->helper->get('FbeenSimpleCmsBundle:Builder:cmsMenu', [], $options);

        return $this->helper->render($menu);
    }
}
