<?php

namespace SanchoBBDO;

class Luniq
{
    protected $secretKey;
    protected $length;

    public function __construct($config)
    {
        $this->secretKey = $config['secretKey'];
        $this->length = isset($config['length']) ? $config['length'] : 1679616;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function of($index)
    {
        $index = base_convert($index, 10, 36);
        $index = str_pad($index, 4, '0', STR_PAD_LEFT);
        $encoded = hash_hmac('sha1', $index, $this->getSecretKey(), true);
        $encoded = trim(base64_encode($encoded));
        return $index.substr($encoded, 0, 6);
    }
}

