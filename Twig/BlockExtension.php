<?php

namespace Fbeen\SimpleCmsBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface; 

class BlockExtension extends \Twig_Extension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('render_block', array($this, 'renderBlockFunction'), array('is_safe' => array('html'))),
        );
    }

    public function renderBlockFunction($name, $options = array())
    {
        $helper = $this->container->get('fbeen.simple_cms.content_helper');
        
        if(!$blockContainer = $helper->findBlockContainer($name))
        {
            return NULL;
        }

        $response = '';
        
        foreach($blockContainer->getBlocks() as $block)
        {
            $blockType = $helper->loadBlockType($block->getType());
            $response .= $blockType->renderBlock($block->getIdentifier(), $options);
        }
        
        return $response;
    }

    public function getName()
    {
        return 'fbeen_simple_cms_block_extension';
    }
}
