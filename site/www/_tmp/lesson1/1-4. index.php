<?php
	/*
	    1. Придумать класс, который описывает любую сущность из предметной области интернет-магазинов: продукт, ценник, посылка и т.п.
        2. Описать свойства класса из п.1 (состояние).
        3. Описать поведение класса из п.1 (методы).
        4. Придумать наследников класса из п.1. Чем они будут отличаться?
	 */

    // Объявление класса
    class prods{
        // Объявление частной переменной
        private $prods = [];
        // а так просто
        function __construct(){
        }
        // Тоже так просто
        function __get($property){
            return "Property: {$property} is not found!";
        }
        // Публичная функция получения массива - примитивная имитация запроса в БД
        function getProdsDB(){
            // Иммитируем запрос в базу
            $arr_prods = [];
            // Запрашиваем скрипт (а там у нас массив с именем $arr_prods)
            require './arr_products.php';
            // Возвращаем массив
            return $arr_prods;
        }
        // Функция получения массива товаров
        function getProds(){
            return $this -> getProdsDB();
        }
    }

    // объявление get_discount_prods - расширенного класса prods
    class get_discount_prods extends prods{
        private $prods = [];
        // Массив со скидками
        private $discounts = [
            'vinyl' => 25,
            'leather' => 15
        ];
        // при создании класса, массив $this -> prods получает данные с БД с товарами всеми
        function __construct(){
            $this -> prods = $this -> getProdsDB();
        }
        // Получаем товары
        // реализация 2, т.е. собирает Html и отдаём его в случае успеха,
        // если успеха нет то ошибку
        // если ошибки нет и html то код возвратим
        function getProds(){
            if(empty($this -> prods)) return [false, '<p>В данный момент товары отсутствуют напрочь!</p>', 'code' => 'empty'];
            elseif(empty($this -> discounts)) return [false, '<p>В данный момент скидок на товары нет!</p>', 'code' => 'empty'];
            else{
                $html = '<table>';
                $has = false;
                foreach($this -> prods as $arr_item){
                    // При работе с базой перебора прямого бы не было
                    if(!empty($this -> discounts[$arr_item['prod_matter']]) && !empty($arr_item['prod_count'])){
                        $prod_price = (float)$arr_item['prod_price'] - ((float)$arr_item['prod_price'] / 100 * (float)$this -> discounts[$arr_item['prod_matter']]);
                        $has = true;
                        $html .= '<td>' .$arr_item['prod_id'] . "</td><td>" . $arr_item['prod_name'] . "</td><td style='text-align: right;'>" . number_format($prod_price, 2, ',', ' ') .  ' ' . '<i style="text-decoration: line-through;">' . $arr_item['prod_price'] . '</i>' . "</td></tr>";
                    }
                }
                $html .= '</table>';
                if(!$has) return [false, '<p>В данный момент товары со скидкой отсутствуют!</p>', 'code' => 'empty'];
            }
            return [true, 'html' => $html];
        }
    }

    // Распродажа залежавшегося товара
    class get_sale_prods extends prods{
        // Сколько минимум должно быть, чтоб учавствовать в распродаже
        private $sale = 5;
        private $discount = 50;
        // Распродажа товаров,
        function getProdsDB(){
            // Иммитируем запрос в базу
            $arr_prods = [];
            require './arr_products.php';
            if(empty($arr_prods)) return [false, 'В данный момент товары отсутствуют напрочь!', 'code' => 'empty'];
            foreach($arr_prods as $_id => $arr_item){
                if(!empty($arr_item['prod_count']) && $arr_item['prod_count'] <= $this -> sale) unset($arr_prods[$_id]);
            }
            if(empty($arr_prods)) return [false, 'В данный момент скидок на товары нет!', 'code' => 'empty'];
            return [true, 'arr' => $arr_prods];
        }
        function get_discount(){
            return $this -> discount;
        }
        function getProds(){
            return $this -> getProdsDB();
        }
    }


    $prods = new prods();
    // echo $prods -> x;
    // var_dump($prods -> getProds());


    $prods = $prods -> getProds();
    if(empty($prods)){
        echo "<p>В данный момент товары отсутствуют!</p>";
    }
    else{
        echo "<table style='/*width: 100%*/'><tr><td>iD</td><td>Naim</td><td>Price</td></tr>";
        foreach($prods as $arr_item){
            echo "<tr><td>" . $arr_item['prod_id'] . "</td><td>" . $arr_item['prod_name'] . "</td><td style='text-align: right;'>" . number_format($arr_item['prod_price'], 2, ',', ' ') . "</td></tr>";
        }
        echo "</table>";
    }

    $prods = new get_discount_prods();
    $__r = $prods -> getProds();

    echo "<hr>Товары со скидкой:<hr>";

    if(!$__r[0] && !empty($__r['code'])){
        echo $__r[1];
    }
    elseif(!$__r[0]){
        echo '<p>Error: ' . $__r[1] . '</p>';
    }
    else{
        echo $__r['html'];
    }

    $prods = new get_sale_prods();
    $__r = $prods -> getProds();

    $discount = $prods -> get_discount();

    if($discount <= 0){
        echo "<p>В данный момент распродажи нет!</p>";
    }
    else{
        echo "<hr>Распродажа:<hr>";
        if(!$__r[0] && !empty($__r['code'])){
            echo $__r[1];
        }
        elseif(!$__r[0]){
            echo '<p>Error: ' . $__r[1] . '</p>';
        }
        else{
            echo "<table style='/*width: 100%*/'><tr><td>iD</td><td>Naim</td><td>Price</td></tr>";
            foreach($__r['arr'] as $arr_item){
                $prod_price = (float)$arr_item['prod_price'] - ((float)$arr_item['prod_price'] / 100 * $discount);
                echo "<tr><td>" . $arr_item['prod_id'] . "</td><td>" . $arr_item['prod_name'] . "</td><td style='text-align: right;'>" . number_format($prod_price, 2, ',', ' ') . ' <i style="text-decoration: line-through;">' . $arr_item['prod_price'] . '</i></td></tr>';
            }
            echo "</table>";
        }
    }



?>