<?php

namespace SanchoBBDO\Codes;

class Codes implements \Iterator
{
    private $coder;
    private $offset;

    protected $position;

    public function __construct($coder, $offset = 0)
    {
        $this->setCoder($coder);
        $this->setOffset($offset);
        $this->rewind();
    }

    public function current()
    {
        return $this->getCoder()->encode($this->position);
    }

    public function rewind()
    {
        $this->position = $this->getOffset();
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

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
}
