<?php 

try{
    // データベースに接続
    $pdo = new PDO(
    // ホスト名、データベース名
    'mysql:host=localhost;dbname=order;',
    // ユーザー名
    'root',
    // パスワード
    '',
    // レコード列名をキーとして取得させる
    [ PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]
);

    $search_word = $_GET["search_word"];
    $begin = $_GET["begin"];
    $size = $_GET["size"];
    $result1 = $_GET["name"];

    // select * from products
    $query2 = 'select * from product limit :begin, :size';
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindValue(':begin', $begin, PDO::PARAM_INT);
    $stmt2->bindValue(':size', $size, PDO::PARAM_INT);
    $stmt2->execute();
    $result2 = $stmt2->fetchAll();
    
    // query
    if ($search_word != ""){
        $query = "select * from product where locate(:search_word, name) > 0";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':search_word', $search_word);
        $stmt->execute();

        $search_result = $stmt->fetchAll();
    }

    require_once 'viewSelect_tpl.php';

      
} catch (PDOException $e){
    // 例外が発生したら無視
    require_once 'viewSelect_tpl.php';
    echo $e->getMessage();
     exit();
}


?>