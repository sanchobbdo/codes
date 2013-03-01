<?php

namespace SanchoBBDO\Codes;

class CodesIterator implements \Iterator
{
    protected $coder;
    protected $position;

    public function __construct(Coder $coder)
    {
        $this->coder = $coder;
        $this->position = 0;
    }

    public function current()
    {
        return $this->coder->encode($this->position);
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
        return $this->position < $this->coder->length;
    }
}
