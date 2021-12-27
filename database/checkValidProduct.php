<?php 
    require_once('../database/connectDB.php');

    if(isset($_POST['product_id'])){
        $stringProductId = $_POST['product_id'];
    }

    $product_id = explode("-",$stringProductId);
    $errorLine = [];

    for($i = 0; $i < count($product_id); $i++){
        $hasProductId = getRowWithValue('product', 'product_id', $product_id[$i]);
        if(!$hasProductId){
            array_push($errorLine, $i);
        }
    }

    $errorLineString = join("-",$errorLine);

    echo $errorLineString;
?>