<?php
require 'ClassAngularJs.php';
$Obj = new ClassAngularJs;
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    $request = json_decode($postdata);
    $id  = (int)$request->did;
    $Obj->DeleteRecords("tbl_user", "id='$id'");  
   
}