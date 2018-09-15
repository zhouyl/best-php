<?php

function loader_first($class)
{
    echo "call autoload: ".__FUNCTION__."\n";
}

function loader_second($class)
{
    echo "call autoload: ".__FUNCTION__."\n";
}

function loader_third($class)
{
    echo "call autoload: ".__FUNCTION__."\n";
}

spl_autoload_register('loader_first');
spl_autoload_register('loader_second');
spl_autoload_register('loader_third', true, true);

// spl_autoload_call("FooClass");
var_dump(class_exists("FooClass"));
