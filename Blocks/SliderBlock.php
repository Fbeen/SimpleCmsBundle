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

class SliderBlock extends AbstractBlock
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template'  => 'FbeenSimpleCmsBundle:Blocks:slider_block.html.twig'
        ));
    }

    public function renderBlock($identifier)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        
        $slider = $em->getRepository('FbeenSimpleCmsBundle:Slider')->findOneBy(array('identifier' => $identifier));

        return $this->container->get('twig')->render($this->options['template'], array(
            'sliderBlock' => $slider
        ));
    }
}
