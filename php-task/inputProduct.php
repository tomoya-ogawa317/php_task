<!Doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>

    <!--css-->
    <link rel="stylesheet" href="inputProduct.css">

</head>
<body>
<div class="fullheight">
<div id="container">
<header id="header">
  <h1>新規</h1>
</header>

<main>
<h2>追加する商品情報を入れてください</h2>
<form action="addProduct.php" method="get">
<select name="new_product_type">
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

    $query = 'select * from type';

    //prepare
    $stmt = $pdo->prepare($query);

    //execute
    $stmt->execute();                                 
    
    $result2 = $stmt->fetchAll();

    foreach($result2 as $row){
        $type_id = $row["type_id"];
        $type_name = $row["name"];
        echo "<option value='" . strval($type_name) . "'>" . $type_name . "</option>";
    }
    
    echo "</select><br>";



} catch (PDOException $e){
    // 例外が発生したら無視
    //require_once 'exception_tpl.php';
    echo $e->getMessage();
    exit();
  }

?>
</select><br>

<input type="text" name="new_product_name" placeholder="新規商品名" required><br>
<input type="number" pattern="^[0-9]+$" name="new_product_price" placeholder="価格" required><br>
<input type='date' name='date' required><br>
<input type="hidden" name="name" value=<?php echo $_GET["name"]; ?>>
<input type='hidden' name='begin' value=<?php echo $_GET["begin"]; ?>>
<input type='hidden' name='size' value=<?php echo $_GET["size"]; ?>>

<input type="submit" name="submitBtn" value="追加">
</form>


</main>
</div>
</div>