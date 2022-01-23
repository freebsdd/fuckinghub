<?php
// Объявление класса
class db{
    protected static $dbh = null;
    function __construct(){}
    private function connect(){
        if(!self::$dbh){
            $user = 'root';
            $pwd = '123';
            try{
                self::$dbh = new PDO('mysql:dbname=php-course;host=localhost', $user, $pwd);
                // self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e){
                return [
                    false, $e -> getMessage()
                ];
            }
        }
        return [
            true, 'gut'
        ];
    }

//    private function getObj(){
//        if(self::$connect === null){
//            self::$connect = new self;
//        }
//        return self::$connect;
//    }

// $db = new db();

//$__r = \db::exec_sql([
//    'query' => " select * from products "
//]);
//
//var_dump($__r);

    static function get_query($arr_opt){
        $get = ((!empty($arr_opt['get'])) ? $arr_opt['get'] : '' );

        if($get == 'products'){
            $query = " select * from products where 1 ";
        }
        elseif($get == 'products'){
            $query = " select * from prod__pics where 1 ";
        }
        // else return [false, 'unknown get'];
        else $query = '';

        return $query;

//        return [
//            true,
//            'query' => $query
//        ];
    }

    function exec_sql__test(){
        $user = 'root';
        $pwd = '123';
        $dbh = new PDO('mysql:dbname=php-course;host=localhost', $user, $pwd);

        $sth = $dbh -> query(" select * from products where 1 ", PDO::FETCH_ASSOC);
        $arr_sql = $sth->fetchAll();
        var_dump($arr_sql);
    }

    function exec_sql($arr_opt){
        $query = ((!empty($arr_opt['query_get'])) ? $arr_opt['query_get'] : '' );
        if(empty($query)) return [false, 'query is empty!'];

        $__r = $this -> connect();
        if(!$__r[0]) return $__r;

        // var_dump($__r);

//        $sql =
//            <<<SQL
//            SELECT ALL
//                c1, -- For result indexing
//                c1, c2
//            FROM (
//                VALUES
//                    ROW('ID-1', 'Value 1'),
//                    ROW('ID-2', 'Value 2a'),
//                    ROW('ID-2', 'Value 2b'),
//                    ROW('ID-3', 'Value 3')
//            ) AS t (c1, c2);
//            SQL;

        // $sth = self::$dbh -> query($query, PDO::FETCH_ASSOC);
        $sth = self::$dbh -> query($query, PDO::FETCH_ASSOC);
        // $sth = self::$dbh -> query($query);

        if(!$sth){
            return [false, self::$dbh->errorCode() . " - " . implode(', ', self::$dbh->errorInfo())];
        }

        // var_dump($sth);

        // print_r($sth->fetchAll(PDO::FETCH_UNIQUE));


        $arr_sql = $sth->fetchAll();
        // var_dump($arr_sql);

//        foreach($arr_sql as $row) {
//            var_dump($row);
//        }


//        if(empty($rows)){
//            $arr_sql = [];
//        }
//        else{
//
////            foreach($rows as ){
////
////            }
//
//            var_dump($rows);
//
////        while ($row = $sth->fetchObject()) {
////            $data[] = $row;
////        }
//
//
//            $arr_sql = [
//                [
//                    'id' => 1,
//                    'name' => 'prod1',
//                    'price' => 1500
//                ],
//            ];
//        }


        return [
            true,
            'arr' => $arr_sql
        ];
    }

}

?>