<?php

namespace Fbeen\SimpleCmsBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface; 
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function hasBlockFunction($section)
    {
        $content = $this->container->get('fbeen.simple_cms.content_helper')->getContent();

        if($content && count($content->getBlocksForSection($section)))
        {
            return true;
        }
        
        return false;
    }
    
    public function renderBlockFunction($name, $options = array())
    {
        $helper = $this->container->get('fbeen.simple_cms.content_helper');
        
        if(!$this->validateSectionName($name))
        {
            throw new NotFoundHttpException('Block "'.$name.'" is does not exist.');
        }
        
        $content = $helper->getContent();

        if(null === $content)
        {
            return NULL;
        }

        $blocks = $content->getBlocksForSection($name);

        if(!count($blocks))
        {
            return NULL;
        }

        $response = '';

        foreach($blocks as $block)
        {
            $blockOptions = $this->getOptionsForBlock($options, $block->getIdentifier());
            
            $blockType = $helper->loadBlockType($block->getType());
            
            $blockType->setOptions($blockOptions);
            
            $response .= $blockType->renderBlock($block->getIdentifier());
        }
        
        return $response;
    }

    private function getOptionsForBlock($allOptions, $identifier)
    {
        foreach($allOptions as $id => $options)
        {
            if(strcasecmp($id, $identifier) == 0)
                return $options;
        }
        
        return array();
    }
    
    public function validateSectionName($name)
    {
        foreach($this->container->getParameter('fbeen_simple_cms.block_container_names') as $section)
        {
            if(strcasecmp($section, $name) == 0)
            {
                return true;
            }
        }
        
        return false;
    }

    public function getName()
    {
        return 'fbeen_simple_cms_block_extension';
    }
}
