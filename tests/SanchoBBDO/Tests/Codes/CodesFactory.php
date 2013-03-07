<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\Codes;

class CodesFactory
{
    public static function createCodes()
    {
        $codes = Codes::from(array(
            'offset' => 10,
            'limit' => 10,
            'secret_key' => 'asdsadsadasd'
        ));

        return $codes;
    }
}
