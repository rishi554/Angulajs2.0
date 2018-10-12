<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'ClassAngularJs.php';
$Obj = new ClassAngularJs;
$Products = $Obj->SelectTable("Products", "", "", 0);
if(count($Products) > 0){
    $json = json_encode($Products);
    echo $json;
    exit;
}else{
    echo "Not Found";
}



