<?php

namespace SanchoBBDO\Tests\Codes\Util;

use SanchoBBDO\Codes\Util\Config;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $config = $this->getConfigurationInterfaceMock();

        $this->assertEquals(
            array('foo' => 'bar'),
            Config::process($config, array('foo' => 'bar'))
        );

        try {
            Config::process($config, array());
            $this->fail("Didn't validate config");
        } catch (InvalidConfigurationException $e) {
        }
    }

    private function getConfigurationInterfaceMock()
    {
        $config = $this->getMock('Symfony\\Component\\Config\\Definition\\ConfigurationInterface');
        $config
            ->expects($this->any())
            ->method('getConfigTreeBuilder')
            ->will($this->returnValue($this->getTreeBuilder()));

        return $config;
    }

    private function getTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('stub');
        $rootNode
            ->children()
                ->scalarNode('foo')
                    ->isRequired()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
