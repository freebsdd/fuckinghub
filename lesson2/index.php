<?php
	/*
        1. Создать структуру классов ведения товарной номенклатуры.
            wtf?? а) Есть абстрактный товар.
            + б) Есть цифровой товар (бонусные рубли?) prod_digital , штучный физический товар (Джинсы) prod_fisical и товар на вес (сахар) prod_weigth.
            + в) У каждого есть метод подсчета финальной стоимости.
            г) У цифрового товара стоимость постоянная – дешевле штучного товара в два раза. У штучного товара обычная стоимость, у весового – в зависимости от продаваемого количества в килограммах. У всех формируется в конечном итоге доход с продаж.
            д) Что можно вынести в абстрактный класс, наследование?
        2. *Реализовать паттерн Singleton при помощи traits.
	 */

spl_autoload_register(function ($class_name) {
    include "classes/$class_name.class.php";
});

// 1. Создать структуру классов ведения товарной номенклатуры.

abstract class abs_prods{
    public const digital_price = 0.5;
    function __construct(){

    }
    //abstract function get_price();
    abstract function get_prods();
    // function
}

// Есть цифровой товар (бонусные рубли?) prod_digital
class prods extends abs_prods{
    function __construct(){
        parent::__construct();
    }
//    function get_price(){
//
//    }
    function get_prods(){
        $arr_prods = [];
        require 'arr_products.php';
        return $arr_prods;
    }
    function getInfo(){
        $arr = $this -> get_prods();
        $html = '<table><tr><td>type</td><td>naim</td><td>sum</td><td>digital</td></tr>';
        foreach($arr as $item){
            if($item['prod_matter'] == 'weight'){
                $weight = rand(1, 500);
                $r = ( (double)$item['prod_price'] * $weight / 100 );
                $prodDigital = $r - $r * self::digital_price;
                $html .= '<tr><td>Весовой</td><td>' . $item['prod_name'] . '</td><td>' . $r . '/ ' . $weight . 'гр</td><td>' . $prodDigital . '</td></tr>';
            }
            else{
                $prodDigital = (double)$item['prod_price'] - (double)$item['prod_price'] * self::digital_price;
                $html .= '<tr><td>Штучный</td><td>' . $item['prod_name'] . '</td><td>' . $item['prod_price'] . '</td><td>' . $prodDigital . '</td></tr>';
            }
        }
        $html .= '</table>';

        return [
            true, 'html' => $html
        ];
    }
}

$q = new prods();

$__r = $q -> getInfo();

echo $__r['html'];


// 2. *Реализовать паттерн Singleton при помощи traits.
trait pub_func{

}

trait Singlton{
    use pub_func;
    private static $inst;
    final protected function __construct(){}
    final protected function __clone(){}
    final public function __wakeup(){
        throw new \Exception("Cannot unserialize a singleton.");
    }
    final public static function getInst(){
        if(!(isset(self::$inst))){
            // self::$inst = new static();
            self::$inst = new self();
        }
        return self::$inst;
    }
//    final function doAct(){
//        echo 'doAct..';
//    }
//    function init(){
//
//    }
}
class A{
    use Singlton;
//    function initAct(){
//
//    }
}
class B{
    use Singlton;
//    function initAct(){
//
//    }
}

$q1 = A::getInst();
$q2 = A::getInst();

//$q1 = Singlton::getInst();
//$q2 = Singlton::getInst();
//
if($q1 === $q2){
    echo 'gut';
}
else{
    echo 'bad!';
}
//
//Singlton::getInst()->doAct();
//Singlton::getInst()->doAct();

?>