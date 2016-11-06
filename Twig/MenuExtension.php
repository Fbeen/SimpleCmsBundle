<?php

namespace Fbeen\SimpleCmsBundle\Twig;

use Knp\Menu\Twig\Helper;

class MenuExtension extends \Twig_Extension
{
    private $helper;

    /**
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function getFunctions()
    {
        return array(
             new \Twig_SimpleFunction('render_menu', array($this, 'render'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders a menu with the cms renderer.
     *
     * @param string    $name
     * @param array     $options
     * @param string    $renderer
     *
     * @return string
     * 
     * THIS TWIG FUNCTION DOES THE SAME AS:
     * {% set menuItem = knp_menu_get('FbeenSimpleCmsBundle:Builder:cmsMenu', [], {'fbeen_simple_cms_name': '<name-of-the-menu>'}) %}        
     * {{ knp_menu_render(menuItem) }}

     */
    public function render($name, array $options = array(), array $templateOptions = array(), $renderer = null)
    {
        $options = array_merge($options, array('fbeen_simple_cms_name' => $name));

        $menu = $this->helper->get('FbeenSimpleCmsBundle:Builder:cmsMenu', [], $options);

        return $this->helper->render($menu,  $templateOptions, $renderer);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'fbeen_simple_cms_menu_extension';
    }
}
