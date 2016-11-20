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
            new \Twig_SimpleFunction('has_block', array($this, 'hasBlockFunction')),
            new \Twig_SimpleFunction('render_block', array($this, 'renderBlockFunction'), array('is_safe' => array('html'))),
        );
    }

    public function hasBlockFunction($name)
    {
        $helper = $this->container->get('fbeen.simple_cms.content_helper');

        if(false === $blockContainer = $helper->findBlockContainer($name))
        {
            return false;
        }
        
        return true;
    }
    
    public function renderBlockFunction($name, $options = array())
    {
        $helper = $this->container->get('fbeen.simple_cms.content_helper');

        if(false === $blockContainer = $helper->findBlockContainer($name))
        {
            return NULL;
        }

        $response = '';
        
        foreach($blockContainer->getBlocks() as $block)
        {
            $blockType = $helper->loadBlockType($block->getType());
            
            /* check if there are options given for this identifier */
            if(isset($options[$block->getIdentifier()])) {
                $blockType->setOptions($options[$block->getIdentifier()]);
            } else {
                $blockType->setOptions(array());
            }
            
            $response .= $blockType->renderBlock($block->getIdentifier());
        }
        
        return $response;
    }

    public function getName()
    {
        return 'fbeen_simple_cms_block_extension';
    }
}
