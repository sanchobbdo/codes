<?php

namespace SanchoBBDO\Codes;

class Codes implements \Iterator
{
    private $coder;
    private $offset;
    private $limit;

    protected $position;

    public function __construct($coder, $offset = 0, $limit = null)
    {
        $this->setCoder($coder);
        $this->setOffset($offset);
        $this->setLimit($limit);
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
        return $this->position < $this->getLimit();
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

    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit = null)
    {
        if (null === $limit) {
            $limit = pow(36, 4);
        }

        $this->limit = $limit;
    }
}
