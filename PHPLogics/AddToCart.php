<?php

require 'ClassAngularJs.php';
$Obj = new ClassAngularJs;

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)){
    
    $request  = json_decode($postdata);
    $id = $request->ProductId;
    $Product = $Obj->SelectSingleRow("Products", "id='$id'",'',0);
    $ExistsFlag = 0;
    
    if($_SESSION['cart_item'] == NULL && empty($_SESSION['cart_item'])){
        $_SESSION['cart_item'] = array();
        $CartItem = array('id'=>$Product['id'],'ProductName'=>$Product['ProductName'],'Amount'=>$Product['Price'],'QTY'=>1);
        array_push($_SESSION['cart_item'],$CartItem);
    }else{
        foreach($_SESSION['cart_item'] as $key => $value){
            
            if($_SESSION['cart_item'][$key]['id'] == $id){
                $_SESSION['cart_item'][$key]['QTY'] = $_SESSION['cart_item'][$key]['QTY'] + 1;
                $_SESSION['cart_item'][$key]['Amount'] = $_SESSION['cart_item'][$key]['QTY'] * $Product['Price'];
                $ExistsFlag = 1;
                break;
            }
        }
        if($ExistsFlag == 0){
            $CartItem = array('id'=>$Product['id'],'ProductName'=>$Product['ProductName'],'Amount'=>$Product['Price'],'QTY'=>1);
            array_push($_SESSION['cart_item'],$CartItem);
        }
    }   
    echo json_encode($_SESSION['cart_item']);
    exit();
    
}