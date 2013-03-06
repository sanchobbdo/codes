<?php

namespace SanchoBBDO\Codes;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CodesConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('codes');
        $rootNode
            ->children()
                ->scalarNode('offset')->end()
                ->scalarNode('limit')->end()
                ->arrayNode('coder')
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
