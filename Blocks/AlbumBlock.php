<?php

namespace Fbeen\SimpleCmsBundle\Blocks;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Fbeen\SimpleCmsBundle\Blocks\AbstractBlock;

/**
 * Description of AlbumBlock
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */

class AlbumBlock extends AbstractBlock
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template'  => 'FbeenSimpleCmsBundle:Blocks:album_block.html.twig',
            'class' => 'albumblock',
        ));
    }

    public function renderBlock($identifier)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        
        $images = $em->getRepository('FbeenSimpleCmsBundle:Image')->findImagesWithTag($identifier);

        return $this->container->get('twig')->render($this->options['template'], array(
            'albumBlock' => array(
                'label' => $identifier,
                'class' => $this->options['class'],
                'images'=> $images
            )
        ));
    }
}
