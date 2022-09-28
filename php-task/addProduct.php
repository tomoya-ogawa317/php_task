<!Doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>

<?php
  $result1 = $_GET["name"];
  $begin = $_GET["begin"];
  $size = $_GET["size"];

  $type = $_GET["new_product_type"];
  $name = $_GET["new_product_name"];
  $price = $_GET["new_product_price"];
  $date = $_GET["date"];
  
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

    // status_idを取得
    $tmp = 'select max(status_id) from status';
    $stmt_tmp = $pdo->prepare($tmp);
    $stmt_tmp->execute();
    $max_status_id = $stmt_tmp->fetchAll()[0]["max(status_id)"] + 1;
  

    // statusテーブルに追加
    $query2 = "insert into status values(:max_status_id, '未発注', null)";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindValue(':max_status_id', $max_status_id, PDO::PARAM_INT);
    $stmt2->execute();
  
    
    // user_id
    // products.order_user = user_id
    $tmp = "select user_id from user where name=:name";
    $stmt_tmp = $pdo->prepare($tmp);
    $stmt_tmp->bindParam(':name', $result1);
    $stmt_tmp->execute();
    $user_id = $stmt_tmp->fetchAll()[0]["user_id"];
    //echo $stmt_tmp->fetchAll()[0];

    //order_status
    $tmp = "select order_status from product where order_user=:user_id";
    $stmt_tmp = $pdo->prepare($tmp);
    $stmt_tmp->bindParam(':user_id', $user_id);
    $stmt_tmp->execute();
    $result2 = $stmt_tmp->fetchAll();

    // type_id
    $tmp = "select type_id from type where name=:type";
    $stmt_tmp = $pdo->prepare($tmp);
    $stmt_tmp->bindParam(':type', $type);
    $stmt_tmp->execute();
    $type_id = $stmt_tmp->fetchAll()[0]["type_id"];
    //echo $type_id;

    

    // insert into products value();
    $query = "insert into product(type, name, price, order_date, order_status, order_user) value(:type_id, :name, :price, :date, :max_status_id, :user_id)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':type_id', $type_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindValue(':max_status_id', $max_status_id, PDO::PARAM_INT);

    $stmt->execute();
    
    // select * from products
    $query1 = 'select * from product limit :begin, :size';
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindValue(':begin', $begin, PDO::PARAM_INT);
    $stmt1->bindValue(':size', $size, PDO::PARAM_INT);
    $stmt1->execute();
    $result2 = $stmt1->fetchAll();

    
    /*
    echo "<input type='hidden' name='name' value='$user_name'>";
    echo "<input type='hidden' name='begin' value='$begin'>";
    echo "<input type='hidden' name='size' value='$size'>";
    */

    require_once 'viewSelect_tpl.php';
    
} catch (PDOException $e){
    // 例外が発生したら無視
    //require_once 'viewSelect_tpl.php';
    echo $e->getMessage();
    exit();
  }

?>

</body>
</html>