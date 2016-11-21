<?php

namespace Fbeen\SimpleCmsBundle\Blocks;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Fbeen\SimpleCmsBundle\Blocks\AbstractBlock;

/**
 * Description of SimpleBlock
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */

class ImageBlock extends AbstractBlock
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template'  => 'FbeenSimpleCmsBundle:Blocks:image_block.html.twig',
            'class' => 'imageblock',
            'width' => '100%',
            'height' => 'auto',
            'alt' => 'image'
        ));
    }

    public function renderBlock($identifier)
    {
        return $this->container->get('twig')->render($this->options['template'], array(
            'imageBlock' => array(
                'url' => $identifier,
                'class' => $this->options['class'],
                'width' => $this->options['width'],
                'height' => $this->options['height'],
                'alt' => $this->options['alt']
            )
        ));
    }
}
