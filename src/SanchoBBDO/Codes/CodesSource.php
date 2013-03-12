<?php

/**
 * @author  Camilo Aguilar <camiloaguilar@sanchobbdo.com.co>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/sanchobbdo/codes
 */

namespace SanchoBBDO\Codes;

use Exporter\Source\SourceIteratorInterface;
use SanchoBBDO\Codes\Codes;

class CodesSource implements SourceIteratorInterface
{
    private $codes;

    public function __construct(Codes $codes)
    {
        $this->codes = $codes;
    }

    public function current()
    {
        return array(
            'code' => $this->codes->current()
        );
    }

    public function key()
    {
        return $this->codes->key();
    }

    public function next()
    {
        $this->codes->next();
    }

    public function rewind()
    {
        $this->codes->rewind();
    }

    public function valid()
    {
        return $this->codes->valid();
    }

    public function getFields()
    {
        return array('codes');
    }
}
