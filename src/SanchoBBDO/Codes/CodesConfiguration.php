<?php

namespace SanchoBBDO\Codes;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class CodesConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('codes');
        $rootNode
            ->children()
                ->scalarNode('secret_key')
                    ->isRequired()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
