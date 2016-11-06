<?php

namespace Fbeen\SimpleCmsBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface; 
use Fbeen\SimpleCmsBundle\Entity\Content;

/**
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */
class ContentHelper
{
    private $container;
    private $content;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function setContent(Content $content)
    {
        $this->content = $content;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function findBlockContainer($name)
    {
        if(NULL === $this->content)
        {
            return FALSE;
        }
        
        foreach($this->content->getBlockContainers() as $blockContainer)
        {
            if($name == $blockContainer->getName())
            {
                return $blockContainer;
            }
        }
        
        return FALSE;
    }
    
    public function loadBlockType($name)
    {
        $types = $this->container->getParameter('fbeen_simple_cms.block_types');
        
        foreach($types as $type)
        {
            if($type['name'] == $name)
            {
                return $this->container->get($type['class']);
            }
        }
        
        throw new \Exception('BlockType with name "'.$name.'" does not exist.');
    }
}
