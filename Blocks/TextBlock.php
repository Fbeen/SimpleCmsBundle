<?php

namespace Fbeen\SimpleCmsBundle\Blocks;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Fbeen\SimpleCmsBundle\Model\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of TextBlock
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */

class TextBlock extends AbstractBlock
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template'  => 'FbeenSimpleCmsBundle:Blocks:text_block.html.twig',
            'class'  => 'textblock',
            'show_title'     => true,
        ));
    }

    public function renderBlock($identifier)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        
        $simpleBlock = $em->getRepository('FbeenSimpleCmsBundle:TextBlockType')->findOneBy(array('name' => $identifier));
        
        return $this->container->get('twig')->render($this->options['template'], array(
            'textBlock' => array(
                'title' => $simpleBlock->getTitle(),
                'body' => $simpleBlock->getBody(),
                'show_title'  => $this->options['show_title'],
                'class'  => $this->options['class']
            )
        ));
    }
}
