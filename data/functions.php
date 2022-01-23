<?php
spl_autoload_register(function ($class_name) {
    include "classes/$class_name.class.php";
});
function get_dir_root(){
    $dir_root = __DIR__;
    $simb = '/';
    if(strpos($dir_root, 'test2.ru') !== false) $simb = '\\';
    $where = 0; $p_where = 0; $p2_where = 0;
    for($i=0; $i<strlen($dir_root); $i++) if(substr($dir_root, $i, 1) == $simb) { $p2_where = $p_where; $p_where = $where; $where = $i;  }
    $dir_root = substr($dir_root, 0, $where);
    return $dir_root;
}
?>