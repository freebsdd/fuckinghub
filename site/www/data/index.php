<?php
    error_reporting(E_ALL);    // ^ E_NOTICE
    ini_set("display_errors", 1);
    //include("file_with_errors.php");

    // var_dump($_GET);
    
    // ini_set("memory_limit", "1000M");
    set_time_limit(0);

    $dir_root = $_SERVER['DOCUMENT_ROOT'];
    $where = 0; $p_where = 0; $p2_where = 0;
    for($i=0; $i<strlen($dir_root); $i++) if(substr($dir_root, $i, 1) == '/') { $p2_where = $p_where; $p_where = $where; $where = $i;  }
    $dir_root = substr($dir_root, 0, $where);

    if(isset($_GET['all_in_one'])){ include '../../../data/all_in_one.php';}
?>