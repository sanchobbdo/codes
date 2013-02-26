<?php

namespace SanchoBBDO;

class Luniq
{
    public function of($index)
    {
        $index = base_convert($index, 10, 36);
        $index = str_pad($index, 4, '0', STR_PAD_LEFT);
        $encoded = hash_hmac('sha1', $index, "secret key", true);
        $encoded = trim(base64_encode($encoded));
        return $index.substr($encoded, 0, 6);
    }
}

