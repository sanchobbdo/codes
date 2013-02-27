<?php

namespace SanchoBBDO;

class Codes implements \Iterator, \ArrayAccess, \Countable
{
    protected $position;

    protected $secretKey;
    protected $length;

    public function __construct($config)
    {
        $this->secretKey = $config['secretKey'];
        $this->length = isset($config['length']) ? $config['length'] : 1679616;

        $this->position = 0;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function current()
    {
        return $this->of($this->position);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return $this->position < $this->getLength();
    }

    public function offsetExists($offset)
    {
        return is_int($offset) && $offset > -1 && $offset < $this->getLength();
    }

    public function offsetGet($offset)
    {
        return $this->of($offset);
    }

    public function offsetSet($offset, $value)
    {
        throw new \Exception("Can't set codes values.");
    }

    public function offsetUnset($offset)
    {
        throw new \Exception("Can't unset codes values.");
    }

    public function count()
    {
        return $this->getLength();
    }

    public function of($digit)
    {
        $index = $this->base36($digit, 4);
        return $this->generateFor($index);
    }

    public function isValid($code)
    {
        $index = $this->parseIndex($code);
        return $this->generateFor($index) == $code;
    }

    protected function parseIndex($code)
    {
        return substr($code, 0, 4);
    }

    protected function base36($digit, $zerofill = 0)
    {
        $base36 = base_convert($digit, 10, 36);
        return str_pad($base36, $zerofill, '0', STR_PAD_LEFT);
    }

    protected function generateFor($index)
    {
        return $index.substr($this->encrypt($index), 0, 6);
    }

    protected function encrypt($index)
    {
        return sha1($index.$this->getSecretKey());
    }
}
