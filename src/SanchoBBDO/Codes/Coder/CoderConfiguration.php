<?php

namespace SanchoBBDO\Codes\Coder;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CoderConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('coder');
        $rootNode
            ->children()
                ->scalarNode('secret_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->integerNode('mac_length')
                    ->min(1)
                    ->defaultValue(6)
                ->end()
                ->integerNode('key_length')
                    ->min(1)
                    ->defaultValue(4)
                ->end()
            ->end();
        return $treeBuilder;
    }
}
