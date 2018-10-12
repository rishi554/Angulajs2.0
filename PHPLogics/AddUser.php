<?php

require 'ClassAngularJs.php';
$Obj = new ClassAngularJs;

// Add the new data to the database.
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    
   $request  = json_decode($postdata); 
   
   $firstname  = preg_replace('/[^a-zA-Z ]/','',$request->firstname);
   $lastname  = preg_replace('/[^a-zA-Z ]/','',$request->lastname);
   $mobile = preg_replace('/[^0-9 ]/','',$request->mobile);
   $email  = preg_replace('/[^a-zA-Z@.0-9 ]/','',$request->email);
   $btnName = $request->btnName;
   
   $UserData = array("FirstName"=>$firstname,"LastName"=>$lastname,"Email"=>$email,"Mobile"=>$mobile);
   $ExistRecord = $Obj->SelectSingleRow("tbl_user", "Email='$email' OR Mobile='$mobile'");
   
   if($btnName == "Add User"){

        if(count($ExistRecord) > 0){
             echo "<div class='alert alert-danger'>User is already exists.</div>";
        }else{
             $result = $Obj->InsertRecords("tbl_user", $UserData ,0);
             echo "<div class='alert alert-success'>User registered successfully.</div>";
        }
   }
   if($btnName == "Update User"){
            
            $id = $request->id;
            $result = $Obj->UpdateRecords("tbl_user","id='$id'",$UserData,0);
            if($result){
                echo "<div class='alert alert-success'>User updated successfully.</div>";
            }else{
                echo "<div class='alert alert-warning'>No changes you made.</div>";
            }
   }
   
}


