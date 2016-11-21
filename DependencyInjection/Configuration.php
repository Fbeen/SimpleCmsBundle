<?php

namespace Fbeen\SimpleCmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fbeen_simple_cms');

        $rootNode
            ->children()
                ->scalarNode('default_controller')
                    ->defaultValue('FbeenSimpleCmsBundle:Content:index')
                ->end()
                ->scalarNode('image_path')
                    ->cannotBeEmpty()
                ->end()
                ->booleanNode('bootstrap_menus')
                    ->defaultTrue()
                ->end()
                ->arrayNode('block_types')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')->end()
                            ->scalarNode('class')->end()
                            ->scalarNode('template')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('block_container_names')->defaultValue(array())
                    ->prototype('scalar')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('route_filters')->defaultValue(array())
                    ->prototype('scalar')->end()
                    ->defaultValue(array('_', 'admin', 'sonata'))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
