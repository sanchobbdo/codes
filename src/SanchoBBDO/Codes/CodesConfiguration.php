<?php

/**
 * @author  Camilo Aguilar <camiloaguilar@sanchobbdo.com.co>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/sanchobbdo/codes
 */

namespace SanchoBBDO\Codes;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CodesConfiguration implements ConfigurationInterface
{
    private static $defaultCoderClass = '\\SanchoBBDO\\Codes\\Coder\\Coder';

    /**
     * @param string
     */
    public static function setDefaultCoderClass($className)
    {
        self::$defaultCoderClass = $className;
    }

    /**
     * @return string
     */
    public static function getDefaultCoderClass()
    {
        return self::$defaultCoderClass;
    }

    /**
     * @return Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
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
                    ->validate()
                    ->always(function($v) {
                        if (empty($v['class'])) {
                            $v['class'] = self::getDefaultCoderClass();
                        }

                        return $v;
                    })
                ->end()
            ->end();

        return $treeBuilder;
    }
}
