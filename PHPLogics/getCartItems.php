<?php

require 'ClassAngularJs.php';
$Obj = new ClassAngularJs;

if($_SESSION['cart_item'] != NULL && !empty($_SESSION['cart_item'])){
    
    $Obj->setJsonEncode($_SESSION['cart_item']);
    $JsonResponse = $Obj->getJsonEncode();
    echo $JsonResponse;
    
}else{
    echo 0;
}
exit();

