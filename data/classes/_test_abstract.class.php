<?php
// namespace test;
abstract class _test_abstract {
    abstract protected function getValue();

    function printValue(){
        print $this -> getValue() . "\n";
    }
}