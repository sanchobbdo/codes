<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\CodesFactory;

class CodesFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $config = array(
        'offset' => 100,
        'limit' => 2000,
        'secret_key' => 'nice secret key'
    );

    public function setUp()
    {
        $this->codes = CodesFactory::build($this->config);
    }

    public function testBuildReturnCodesInstance()
    {
        $this->assertInstanceOf('\\SanchoBBDO\\Codes\\Codes', $this->codes);
    }

    public function testBuildSetsOffsetOnCodesInstanceFromConfig()
    {
        $this->assertEquals($this->config['offset'], $this->codes->getOffset());
    }

    public function testBuildSetsLimitOnCodesInstanceFromConfig()
    {
        $this->assertEquals($this->config['limit'], $this->codes->getLimit());
    }

    public function testBuildSetsSecretKeyOnCoderFromConfig()
    {
        $this->assertEquals($this->config['secret_key'], $this->codes->getCoder()->getSecretKey());
    }
}
