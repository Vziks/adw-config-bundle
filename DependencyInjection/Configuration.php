<?php

namespace ADW\ConfigBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 * Project ConfigBundle.
 *
 * @author Anton Prokhorov
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('adw_config');

        $rootNode
            ->children()
                ->arrayNode('rules')
                    ->prototype('array')
                        ->children()
                            ->enumNode('rule')->isRequired()->cannotBeEmpty()->values(['+', '-'])->end()
                            ->arrayNode('firewalls')
                                ->beforeNormalization()
                                    ->ifString()->then(function ($v) {
                                        return [$v];
                                    })
                                ->end()
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
            ->end();

        return $treeBuilder;
    }
}
