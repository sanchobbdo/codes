<?php

/**
 * @author  Camilo Aguilar <camiloaguilar@sanchobbdo.com.co>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/sanchobbdo/codes
 */

namespace SanchoBBDO\Codes\Coder;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CoderConfiguration implements ConfigurationInterface
{
    /**
     * @return Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
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
                ->scalarNode('algo')
                    ->defaultValue('sha1')
                    ->validate()
                    ->ifNotInArray(hash_algos())
                        ->thenInvalid('Invalid algo "%s"')
                ->end()
            ->end();
        return $treeBuilder;
    }
}
