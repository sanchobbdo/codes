<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\CodesConfiguration;
use Symfony\Component\Config\Definition\Processor;

class CodesConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->config = new CodesConfiguration;
    }

    protected function process($config)
    {
        $processor = new Processor;
        return $processor->processConfiguration($this->config, $config);
    }

    public function testImplementsConfigurationInterface()
    {
        $this->assertInstanceOf('Symfony\\Component\\Config\\Definition\\ConfigurationInterface', $this->config);
    }
}
