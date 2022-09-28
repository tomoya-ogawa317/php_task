<!Doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>

    <!--css-->
    <link rel="stylesheet" href="showEdit.css">

</head>
<body>
<div class="fullheight">
<div id="container">
  <header id="header">
    <h1>編集</h1>
  </header>

<main>
<h2>商品情報を入れてください</h2>
<?php
$product_id = $_GET["product_id"];
$result1 = $_GET["name"];
$begin = $_GET["begin"];
$size = $_GET["size"];

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

  $kind_of_status = array('発注済', '納品済', '未発注');
  
  // SQL文をセット
  $query = 'select * from product where product_id = :product_id';
  $query1 = 'select * from type';
  $query_tmp = 'select type from product where product_id = :product_id'; 

  // prepare
  $stmt = $pdo->prepare($query);
  $stmt1 = $pdo->prepare($query1);
  $tmp = $pdo->prepare($query_tmp);
  
  //$stmt->bindParam(':product_name', $product_name);
  //$stmt->bindValue(':product_price', $product_price, PDO::PARAM_INT);
  $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
  $tmp->bindValue(':product_id', $product_id, PDO::PARAM_INT);
  

  // execute
  $stmt->execute();
  $stmt1->execute();
  $tmp->execute();
  
  $result = $stmt->fetchAll();
  $result2 = $stmt1->fetchAll();
  $type = $tmp->fetchAll()[0]["type"];

  // status.status_id = products.order_status (商品の状態を取得)
  $order_status = $result[0]["order_status"];
  $query_status = 'select status from status where status_id = :order_status';  // status_id = order_status
  $stmt_status = $pdo->prepare($query_status);
  $stmt_status->bindValue(':order_status', $order_status, PDO::PARAM_INT);
  $stmt_status->execute();
  $status = $stmt_status->fetchAll()[0]["status"];
  /*if($status == null) {
    print("nullです");
  } else {
    print("nullじゃない");
  }
  */

  // 更新
  echo "<form action='editProduct.php'>";
  echo "分類　　　<select name='product_type'>";
  foreach($result2 as $row){
    $type_id = $row["type_id"];
    $type_name = $row["name"];

    if ($row["type_id"]==$type){
    echo "<option value='" . strval($type_name) . "' selected >" . $type_name . "</option>";
    }
    else {
      echo "<option value='" . strval($type_name) . "'>" . $type_name . "</option>";
    }
  }
  echo "</select><br>";

  foreach($result as $row){
    $product_id = $row["product_id"];
    $name = $row["name"];
    $price = $row["price"];
    $order_date = $row["order_date"];
    $order_status = $row["order_status"];
    $order_user = $row["order_user"];
                                  
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "商品名　　<input type='text' name='product_name' placeholder='商品名' value='$name' required><br>";
    echo "価格　　　<input type='number' name='product_price' placeholder='価格' value='$price' required><br>";
    echo "注文日時　<input type='date' name='order_date' value='$order_date' required><br>";

    echo "状態　　　";
    echo "<select name='status'>";
    foreach($kind_of_status as $row){  
      if ($row==$status){
      echo "<option value='" . $row . "' selected >" . $row . "</option>";
      }
      else {
        echo "<option value='" . $row . "'>" . $row . "</option>";
      }
    }
    echo "</select><br>";

    echo "注文者　　<input type='text' name='order_user' placeholder='注文者' value='$order_user'><br>";
    echo "<p></p>";
  }

  // ok_button
  echo "<table>";
  echo "<tr>";
  echo "<td>";
  echo "<input type='hidden' name='name' value='$result1'>";
  //echo "<input type='hidden' name='user_id' value='$user_id'>";
  echo "<input type='hidden' name='begin' value='$begin'>";
  echo "<input type='hidden' name='size' value='$size'>";
  echo "<input type='hidden' name='order_status' value='$order_status'>";
  echo "<input type='submit' name='submitBtn' value='完了'>";
  echo "</form>";
  echo "</td>";

  // delete_button
  echo "<td>";
  echo "<form action='confirmDelete.php'>";
  echo "<input type='hidden' name='product_id' value='$product_id'>";
  echo "<input type='hidden' name='name' value='$result1'>";
  echo "<input type='hidden' name='begin' value='$begin'>";
  echo "<input type='hidden' name='size' value='$size'>";
  echo "<input type='hidden' name='order_status' value='$order_status'>";
  echo "<input type='submit' name='submitBtn' value='削除'>";
  echo "</form>";
  echo "</td>";
  echo "</tr>";
  echo "</table>";

} catch (PDOException $e) {
    // 例外が発生したら無視
    //require_once 'exception_tpl.php';
    echo $e->getMessage();
    exit();
}
?>
</main>
</div>
</div>