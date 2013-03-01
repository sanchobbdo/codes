<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\Utils;

class UtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testCamelToSnake()
    {
        $this->assertEquals('soy_una_serpiente', Utils::camelToSnake('soyUnaSerpiente'));
    }
}
