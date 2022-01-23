<?php
spl_autoload_register(function ($class_name) {
    include "$class_name.class.php";
});
class site{
    private $dir_root = '';

    // limit N,25
    public
        // $limit = 25,        // Отсутп с начала сколько показывать - НАФИК НЕ НУЖЕН
        $limit_count = 25;  // Сколько показывать

    function __construct(){
        $this -> dir_root = \get_dir_root();
    }
    function get_prods($arr_opt = []){
        $db = new DB();
        $limit = ((!empty($arr_opt['limit'])) ? (int)$arr_opt['limit'] : 0 );
        $limit_count = ((!empty($arr_opt['limit_count'])) ? (int)$arr_opt['limit_count'] : 0 );
        if($limit > 0 && $limit_count > 0){
            // Если есть и начало и конец
            $wh = " limit $limit, $limit_count ";
        }
        elseif($limit > 0){
            // начала нет, то значится-с так, начинаем с нуля-с сударь-с
            $wh = " limit $limit ";
        }
        else $wh = '';

        $query = " select * from products p where prod_state is null order by prod_name  $wh ";

        $__r = $db -> exec_sql([
            'query_get' => $query
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
        }
        return [
            true,
            'arr' => $arr_prods,
            // 'query' => $query
        ];
    }

    function sub_func($arr_opt){
        $target = ((!empty($arr_opt['target'])) ? $arr_opt['target'] : '' );

        $arr_sbor = ((!empty($arr_opt['arr_sbor'])) ? $arr_opt['arr_sbor'] : [] );
        if(!is_array($arr_sbor)) return [false, 'arr_sbor must be array!'];

        if($target == 'load_more'){
            $limit = ((!empty($arr_sbor['limit'])) ? (int)$arr_sbor['limit'] : 0 );

            // var_dump($arr_sbor);

            $limit += $this -> limit_count;

            $__r = $this -> get_prods([
                'limit' => $limit,
                'limit_count' => $this -> limit_count
            ]);

            // require '../../vendor/autoload.php';
            require $this -> dir_root . '/data/vendor/autoload.php';

            // require_once '/path/to/vendor/autoload.php';

            $loader = new \Twig\Loader\FilesystemLoader($this -> dir_root . '/site/www/templates');
            $twig = new \Twig\Environment($loader, [
                // 'cache' => '../../temp/twig_cache',
                'debug' => true,
                'autoescape' => false,
            ]);

//            $assigns['document'] = [
////                'title' => 'Список товаров',
////                'h1' => 'Список товаров',
////                'place' => 'products',
//                'arr_prods' => $__r['arr']
//            ];

            $assigns = [
                'blush' => 1,
                'arr_prods' => $__r['arr']
            ];

            // $tpl = $twig->load('products.tpl');
            $tpl = $twig->load('product_line_item.tpl');
            // $assigns['document']['content'] = $tpl->render($assigns);

            return [
                true,
                // 'query' => $__r['query'],
                'prod_act' => [
                    'action' => $target,
                    'limit' => $limit,
                    'content' => $tpl->render($assigns),
                ]
            ];

            return [false, 'Under construction'];
        }
        else return [false, 'unknown target: ' . $target];
    }
}
?>