<!DOCTYPE html>
<html lang="ja">
<head>
        <meta charset="utf-8">
        <title></title>

        <!--css-->
        <link rel="stylesheet" href="viewSelect.css"></link>

</head>
<body>
<div class="fullheight">
<div class="title">
<header id="header">
    <h1>商品情報</h1>
</header>
</div>

<form action="search.php" name="search" method="get">
    <input type="text" name="search_word" placeholder="商品名">
    <input type="hidden" name="name" value=<?php echo $result1; ?>>
    <!--input type="hidden" name="result2" value=<!?php echo $result2; ?>-->
    <input type="hidden" name="begin" value=<?php echo $begin; ?>>
    <input type="hidden" name="size" value=<?php echo $size; ?>>
    <input type="submit" name="submitBtn" value="検索">
</form>

<main>
<h2>ようこそ <?php echo $result1; ?>　さん</h2>
<?php
foreach($result2 as $row){
    echo '<p>';
    echo "<form action='showEdit.php' method='get'>";
    echo "<input type='submit' name='edit_product_btn' value='変更'>";
    $product_id = $row["product_id"];
    $product_name = $row["name"];
    $product_price = $row["price"];
    echo $product_id;
    echo '：';
    echo $product_name;
    echo ', ￥';
    echo $product_price;
    echo "<input type='hidden' name='begin' value='$begin'>";
    echo "<input type='hidden' name='size' value='$size'>";
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "<input type='hidden' name='name' value='$result1'>";
    echo '</p>';
    echo "</form>";
}
?>

<table>
<tr>
<td>
<form action="selection.php" method="get">
    <input type="hidden" name="name" value="<?php echo $result1; ?>">
    <input type="hidden" name="result1" value="<?php echo $result1; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" name="begin" value="
<?php
    $next = $begin - 5;
    if ($next < 0) {
        $next = 0;
    }
    echo $next; ?>">
    <input type="hidden" name="size" value="<?php echo $size; ?>">
    <input type="submit" name="submitBtn" value="前の５件">

</form>
</td>

<td>
<form action="selection.php" method="get">
    <input type="hidden" name="name" value="<?php echo $result1; ?>">
    <input type="hidden" name="result1" value="<?php echo $result1; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" name="begin" value="<?php echo $begin+5; ?>">
    <input type="hidden" name="size" value="<?php echo $size; ?>">
    <input type="submit" name="submitBtn" value="次の５件">
</form>
</td>
</tr>
</table>

<form action="inputProduct.php" method="get">
    <input type="hidden" name="name" value=<?php echo $result1; ?>>
    <input type="hidden" name="begin" value=<?php echo $begin; ?>>
    <input type="hidden" name="size" value=<?php echo $size; ?>>
    <input type="submit" name="submitBtn" value="新規">
</form>
</main>

<div class="search_result" style="overflow: scroll; width:250px; height:300px;">
<?php 
    if (isset($search_result)){
        echo "RESULT：<br>";
        foreach($search_result as $row){
            echo '<p>';
            #echo "<form action='editProduct.php' method='get'>";
            #echo "<input type='submit' name='edit_product_btn' value='edit' style='background: transparent; cursor: pointer;'>";
            $product_id = $row["product_id"];
            $product_name = $row["name"];
            $product_price = $row["price"];
            echo $product_id;
            echo '：';
            echo $product_name;
            echo ', ';
            echo "￥" . $product_price;
            echo "<input type='hidden' name='begin' value='$begin'>";
            echo "<input type='hidden' name='size' value='$size'>";
            echo "<input type='hidden' name='product_id' value='$product_id'>";
            echo "<input type='hidden' name='name' value='$result1'>";
            echo "</form>";  
            echo '</p>';
        }
    }
?>
</div>
</div>
</body>
</html>