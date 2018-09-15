<?php

class MyIterator implements Iterator
{
    private $position = 0;

    private $array = [1, 2, 3, 4, 5];

    public function __construct()
    {
        $this->position = 0;
    }

    public function rewind()
    {
        echo 'Call '.__METHOD__.PHP_EOL;
        $this->position = 0;
    }

    public function current()
    {
        echo 'Call '.__METHOD__."()\n";

        return $this->array[$this->position];
    }

    public function key()
    {
        echo 'Call '.__METHOD__."()\n";

        return $this->position;
    }

    public function next()
    {
        echo 'Call '.__METHOD__."()\n";
        ++$this->position;
    }

    public function valid()
    {
        echo 'Call '.__METHOD__."()\n";

        return isset($this->array[$this->position]);
    }
}

$it = new MyIterator;

foreach ($it as $key => $value) {
    var_export([$key, $value]);
    echo "\n\n";
}
