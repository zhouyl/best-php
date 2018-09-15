<?php

class MyArray implements ArrayAccess
{
    protected $data = [];

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        // return $this->data[$offset];
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}

$arr = new MyArray;

$arr['foo'] = 'bar';

/*
array (
  0 => 'bar',
  1 => NULL,
  2 => true,
  3 => false,
)
*/
var_export([
    $arr['foo'],
    $arr['bar'],
    isset($arr['foo']),
    isset($arr['bar']),
]);

unset($arr['foo']);

/*
array (
  0 => NULL,
  1 => false,
)
*/
var_export([
    $arr['foo'],
    isset($arr['foo']),
]);
