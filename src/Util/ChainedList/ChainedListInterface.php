<?php

namespace App\Util\ChainedList;

interface ChainedListInterface extends \Iterator
{
    public function current();

    public function previous();

    public function next();

    public function key();

    public function rewind();

    public function valid();

    public function size();

    public function add($data);

    public function remove($position);
}