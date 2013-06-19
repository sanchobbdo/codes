<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\CodesConfiguration;
use Symfony\Component\Config\Definition\Processor;

/**
 * @backupStaticAttributes enabled
 */
class CodesConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->configuration = new CodesConfiguration();
        $this->processor = new Processor();
    }

    private function processConfiguration($config)
    {
        return $this->processor->processConfiguration($this->configuration, array($config));
    }

    public function testAcceptsArbitraryCoderChilds()
    {
        $config = $this->processConfiguration(array(
            'coder' => array(
                'foo' => 'bar'
            )
        ));

        $this->assertTrue(isset($config['coder']['foo']));
        $this->assertEquals('bar', $config['coder']['foo']);
    }

    public function testSetDefaultInCoderClass()
    {
        $config = $this->processConfiguration(array(
            'coder' => array()
        ));

        $this->assertTrue(isset($config['coder']['class']));
    }

    public function testSetDefaultCoder()
    {
        CodesConfiguration::setDefaultCoderClass('MyClass');

        $config = $this->processConfiguration(array(
            'coder' => array()
        ));

        $this->assertEquals('MyClass', $config['coder']['class']);

    }
}
