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
    }

    abstract public function configureOptions(OptionsResolver $resolver);
    
    public function setOptions($options)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    abstract public function renderBlock($identifier);
}
