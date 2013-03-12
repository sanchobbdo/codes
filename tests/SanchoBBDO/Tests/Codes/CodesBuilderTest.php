<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\CodesBuilder;

class CodesBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildCodesGeneratesACodesInstanceWithProvidedArgs()
    {
        $config = array(
            'offset' => 100,
            'limit' => 2000,
            'coder' => array(
                'secret_key' => 'secret-key'
            )
        );

        $codes = CodesBuilder::buildCodes($config);

        $this->assertInstanceOf('\\SanchoBBDO\\Codes\\Codes', $codes);
        $this->assertEquals($config['offset'], $codes->getOffset());
        $this->assertEquals($config['limit'], $codes->getLimit());
        $this->assertEquals($config['coder']['secret_key'], $codes->getCoder()->getSecretKey());
    }
}
