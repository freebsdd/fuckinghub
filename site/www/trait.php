<?php
trait MyTrait {
    public function myFunc() {
        return 2 + 2;
    }
}
class test{
    use MyTrait;
    function getID(){
        return $this -> myFunc();
    }
}

$t = new test();
var_dump(
    $t -> myFunc(
        //
    )
);

?>
