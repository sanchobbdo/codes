<?php

namespace SanchoBBDO\Codes;

class Codes implements \Iterator
{
    protected $coder;
    protected $position;

    public function __construct($coder)
    {
        $this->setCoder($coder);
        $this->position = 0;
    }

    public function current()
    {
        return $this->getCoder()->encode($this->position);
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
        return $this->position < $this->getCoder()->length;
    }

    public function getCoder()
    {
        return $this->coder;
    }

    public function setCoder(Coder $coder)
    {
        $this->coder = $coder;
    }
}
