<?php
    $user_id = $_GET["user_id"];
    $password = $_GET["password"];
    #$begin = $_GET["begin"];
    #$size = $_GET["size"];

    $name = NULL;
    $begin = 0;
    $size = 5;

    try {
        // データベースに接続
        $pdo = new PDO(
            // ホスト名、データベース名
            'mysql:host=localhost;dbname=order;charset=utf8;',
            // ユーザー名
            'root',
            // パスワード
            '',
            // レコード列名をキーとして取得させる
            [ PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]
        );
    
        // SQLクエリ作成
        $query = 'select * from user where user_id = :user_id and password = :password';
        $query1 = 'select name from user where user_id = :user_id and password = :password';

        // SQL文をセット
        $stmt = $pdo->prepare($query);
        $stmt1 = $pdo->prepare($query1);
        
        // バインド
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':password', $password);
        $stmt1->bindParam(':user_id', $user_id);
        $stmt1->bindParam(':password', $password);

        // SQL文を実行
        $stmt->execute();
        $stmt1->execute();

        // 実行結果のフェッチ
        $result = $stmt->fetchAll();
        $result1 = $stmt1->fetchAll()[0]["name"];
        
        /*
        var_dump($result);
        if(empty($result)) {
            require_once 'login.html';
        } else {
            $user_name = $result[0]["name"];
        */
            
            // 5件 検索
            $query2 = 'select * from product order by product_id limit :begin, :size';

            $stmt2 = $pdo->prepare($query2);
            $stmt2->bindParam(':begin', $begin, PDO::PARAM_INT);
            $stmt2->bindParam(':size', $size, PDO::PARAM_INT);
            $stmt2->execute();
            $result2 = $stmt2->fetchAll();
            
            require_once 'viewSelect_tpl.php';
        } 

    catch (PDOException $e) {
        // 例外が発生したら無視
        //require_once 'exception_tpl.php';
        echo $e->getMessage();
        exit();
    }

    /*
    // ループして1レコードずつ取得
    foreach ($stmt as $row) {
        echo ($row["user_id"]);
        echo ", ";
        echo ($row["name"]);
        echo ", ";
        echo ($row["password"]);
        echo ", ";
        echo ($row["permission"]);
        echo "<BR>";
    }
    */
    
        #require_once 'login_tpl.php';
    

?>