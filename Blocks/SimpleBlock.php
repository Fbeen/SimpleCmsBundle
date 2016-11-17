<?php

namespace Fbeen\SimpleCmsBundle\Blocks;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Fbeen\SimpleCmsBundle\Model\BlockInterface;

/**
 * Description of SimpleBlock
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */

class SimpleBlock extends AbstractBlock
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template'  => 'FbeenSimpleCmsBundle:Blocks:simple_block.html.twig',
            'show_title'     => true,
        ));
    }

    public function renderBlock($identifier)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        
        $simpleBlock = $em->getRepository('FbeenSimpleCmsBundle:SimpleBlockType')->findOneBy(array('name' => $identifier));
        
        return $this->container->get('twig')->render($this->options['template'], array('simpleBlock' => $simpleBlock));
    }
}
