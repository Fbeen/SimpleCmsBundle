<?php

namespace Fbeen\SimpleCmsBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface; 
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    
    /*
     * Loads a content on the content->name property.
     */
    public function loadContent($name)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
                
        $content = $em->getRepository('FbeenSimpleCmsBundle:Content')->findCompleteContent($name);
        
        if(null === $content)
        {
            throw new NotFoundHttpException('No content available for "'.$name.'"');
        }
        
        $this->setContent($content);
    }

    public function setContent(Content $content)
    {
        $this->content = $content;
        $this->container->get('twig')->addGlobal('content', $content);
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function findBlockContainer($name)
    {
        if(NULL === $this->content)
        {
            throw new NotFoundHttpException('No content available. Should you load the content for this route manualy?');
        }
        
        return $this->content->findBlockContainer($name);
    }
    
    public function loadBlockType($name)
    {
        $types = $this->container->getParameter('fbeen_simple_cms.block_types');

        foreach($types as $type)
        {
            if($type['name'] == $name)
            {
                $block = $this->container->get($type['class']);
                
                if(isset($type['template']) && !empty($type['template'])) {
                    $block->setTemplate($type['template']);
                }
                
                return $block;
            }
        }
        
        throw new \Exception('BlockType with name "'.$name.'" does not exist.');
    }
}
