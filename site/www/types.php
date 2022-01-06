<?php
class MyClass {
    public function names(array $names) {                                      // Тип Аrray
        $res = "<ul>";
        foreach($names as $name) {
            $res .= "<li>{$name}</li>";
        }
        return $res .= "</ul>";
    }
    public function otherClassTypeFunc(OtherClass $otherClass) { // Тип OtherClass
        return $otherClass->var1;
    }
}
$obj = new MyClass;
$names = array(
    'Иван Андреев',
    'Олег Симонов',
    'Андрей Ефремов',
    'Алексей Самсонов'
);
echo $obj->names($names);                                                                    // Работает
$names = "Олег Симонов";
// Получим фатальную ошибку: Argument 1 passed to MyClass::names() must be of the type array, string given
//echo $obj->names($names);
// Получим фатальную ошибку: Argument 1 passed to MyClass::names() must be an instance of OtherClass, string given
echo $obj->otherClassTypeFunc("test string");
?>
