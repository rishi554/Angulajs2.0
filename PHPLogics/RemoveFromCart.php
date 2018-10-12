<?php

require 'ClassAngularJs.php';
$Obj = new ClassAngularJs;

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)){
    
    $request  = json_decode($postdata);
    $id = $request->ProductId;
    
    if(!$_SESSION['cart_item'] == NULL && !empty($_SESSION['cart_item'])){
        
        foreach($_SESSION['cart_item'] as $key => $value){
            
            if($_SESSION['cart_item'][$key]['id'] == $id){
                unset($_SESSION['cart_item'][$key]);
                break;
            }
        }
    }  
    exit();
}