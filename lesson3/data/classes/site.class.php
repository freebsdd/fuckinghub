<?php
class site{
    function __construct(){

    }
    function get_prods($arr_opt = []){
        $db = new DB();
        $__r = $db -> exec_sql([
            'query_get' => " select * from products p where prod_state is null order by prod_name "
        ]);
        if(!$__r[0]) return $__r;

        $arr_prods = [];

        // var_dump($__r['arr']);

        if(!empty($__r['arr'])){
            $arr_ids = [];
            foreach($__r['arr'] as $item){
                $arr_ids[] = $item['prod_id'];
                $arr_prods['products'][$item['prod_id']]['data'] = $item;
                if(!isset($arr_prods['products'][$item['prod_id']]['pics'])) $arr_prods['products'][$item['prod_id']]['pics'] = [];
            }
            $__r = $db -> exec_sql([
                'query_get' => " select * from prod__pics pp where pp_prod_id in(" . implode(',', $arr_ids) . ") "
            ]);
            if(!$__r[0]) return $__r;
            foreach($__r['arr'] as $item){
                $arr_prods['products'][$item['pp_prod_id']]['pics'][] = $item;
            }
            // var_dump($arr_prods);
        }

        return [
            true,
            'arr' => $arr_prods
        ];
    }
}
?>