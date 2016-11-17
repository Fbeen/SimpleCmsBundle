<?php

namespace Fbeen\SimpleCmsBundle\Blocks;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Fbeen\SimpleCmsBundle\Model\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base class for all blocks
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */

abstract class AbstractBlock implements BlockInterface
{
    protected $container;
    protected $options;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->options = array();
    }
    
    public function setTemplate($template)
    {
        $this->options['template'] = $template;
    }

    abstract public function configureOptions(OptionsResolver $resolver);
    
    public function setOptions($options)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        
        /* overwrite template settings in config.yml */
        $options = array_merge($options, $this->options);
        
        $this->options = $resolver->resolve($options);
    }

    abstract public function renderBlock($identifier);
}
