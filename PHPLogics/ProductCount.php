<?php

require 'ClassAngularJs.php';
$Obj = new ClassAngularJs;

if(!isset($_SESSION['cart_item']) && empty($_SESSION['cart_item'])){
    $_SESSION['cart_item'] = array();
}

echo count($_SESSION['cart_item']);
exit();