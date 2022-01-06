<?php
require 'functions.php';
function _return($arr){
    echo json_encode($arr);
    exit();
}
$act = ((!empty($_POST['act'])) ? (int)$_POST['act'] : 0);
if($act <= 0) _return([false, 'act is not supplied!']);

// var_dump($_POST);

$arr_sbor = array();
if(isset($_POST['add_opt_v2'])){
    if(!isset($_POST['add_opt_v2']['opt'])){
        _return(['false', 'Неверное переданы параметры!']);
    }
    $arr_sbor = $_POST['add_opt_v2']['opt'];
}

switch($act):
    case 1:
        $pl = ((!empty($arr_sbor['pl'])) ? $arr_sbor['pl'] : '' );
        if($pl == 'site'){
            require 'classes/site.class.php';
            $site = new site();
            $arr_answer = $site -> sub_func([
                // 'pl' => ((!empty($arr_sbor['pl'])) ? $arr_sbor['pl'] : '' ),
                'target' => ((!empty($arr_sbor['action'])) ? $arr_sbor['action'] : '' ),
                'arr_sbor' => $arr_sbor
            ]);
        }
        else $arr_answer = [false, 'unknown pl'];

        break;
    default: $arr_answer = [false, 'What U want?'];
endswitch;

echo json_encode($arr_answer);
?>