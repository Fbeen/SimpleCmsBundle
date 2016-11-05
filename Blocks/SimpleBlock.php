<?php

namespace Fbeen\SimpleCmsBundle\Blocks;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Fbeen\SimpleCmsBundle\Model\BlockInterface;

/**
 * Description of SimpleBlock
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */

class SimpleBlock implements BlockInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function renderBlock($identifier)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        
        $simpleBlock = $em->getRepository('FbeenSimpleCmsBundle:SimpleBlockType')->findOneBy(array('name' => $identifier));
        
        return $this->container->get('twig')->render('FbeenSimpleCmsBundle:Blocks:simple_block.html.twig', array('simpleBlock' => $simpleBlock));
    }
}
