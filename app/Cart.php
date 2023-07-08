<?php

namespace App;

class Cart
{

    protected $items = [];

    public function __construct( $items = [])
    {
        $this->items = $items;
    }

    public function has($item) {
        return in_array($item, $this->items);
    }
    public function tokenOne()  {
        return array_shift($this->items);
    }
}