<?php
//require_once 'lib/Autoloader.php';
//require_once 'Twig/Autoloader.php';
//Twig_Autoloader::register();

    // require 'lib/twig/Loader/ArrayLoader.php';
    // require 'lib/twig/Loader/LoaderInterface.php';
    // Twig_Autoloader::register();

    spl_autoload_register(function ($class_name) {
        include "../../data/classes/$class_name.class.php";
    });

    // require '../../data/classes/db.class.php';

    require '../../data/vendor/autoload.php';

    // require_once '/path/to/vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader, [
        // 'cache' => '../../temp/twig_cache',
        'debug' => true,
        'autoescape' => false,
    ]);

    $template = $twig->load('html.tpl');

    if(isset($_GET['tovary'])){
        $place = 'products';

        $assigns['document'] = [
            'title' => 'Список товаров',
            'h1' => 'Список товаров',
        ];

//        $db = new DB();
//        // $__r = $db -> exec_sql('select * from products where 1');
//        // $__r = $db -> exec_sql(db::get_query(['get' => 'products']) . " limit 1 ");
//        $__r = $db -> exec_sql(['query_get' => db::get_query(['get' => 'products'])]);

        $site = new site();
        $__r = $site -> get_prods();
        if(!$__r[0]){
            $assigns['document']['content'] = $__r[1];
        }
        else{
            $assigns['arr_prods'] = $__r['arr'];
            // $tpl = 'products';
            // var_dump($assigns['arr_prods']);
            $tpl = $twig->load('products.tpl');
            $assigns['document']['content'] = $tpl->render($assigns);
//             $assigns['document']['content'] = $twig->renderBlock('products.tpl', $assigns);
        }
    }
    elseif(isset($_GET['kontakty'])){
        $place = 'contacts';

        $assigns['document'] = [
            'title' => 'Контакты магазина',
            'h1' => 'О нас',
            'content' => 'Телефон нашей компании'
        ];

        $tpl = 'page';
    }
    else{
        // main page
        $place = 'main';

        $assigns['document'] = [
            'title' => 'Главная страница',
            'h1' => 'Главная страница',
            'content' => 'Контент главной страницы'
        ];
    }


    // var_dump($__r);

    // echo $template->render(['the' => 'variables', 'go' => 'here']);

    echo $template->render($assigns);

?>