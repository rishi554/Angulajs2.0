<?php

require 'ClassAngularJs.php';
$Obj = new ClassAngularJs;
$people = $Obj->SelectTable( "tbl_user", "", "", 0);
if(count($people) > 0){
    $json = json_encode($people);
    echo $json;
    exit;
}else{
    echo "Not Found";
}

