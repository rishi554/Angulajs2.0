<?php
session_start();
class ClassAngularJs {
    
    private $hostname;
    private $dbuser;
    private $dbpass;
    private $dbname;
    private $conn;
    private $json_encode;
    private $json_decode;
    
    public function __construct(){
        $this->setConfiguration("localhost","root","","angular_db");
    }
    public function getConfiguration(){
        return $this->conn;
    }  
    function setConfiguration($hostname,$dbuser,$dbpass,$dbname){
        
        $this->hostname = $hostname;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
        $this->dbname = $dbname;
        $this->conn = mysqli_connect($this->hostname,$this->dbuser,$this->dbpass,$this->dbname);
        
    }
    public function setJsonEncode($JsonResponse){
        $this->json_encode = json_encode($JsonResponse);
    }
    public function getJsonEncode(){
        return $this->json_encode;
    }
    public function setJsonDecode($JsonResponse){
        $this->json_decode = json_decode($JsonResponse);
    }
    public function getJsonDecode($JsonResponse){
        return $this->json_decode;
    } 
    function SelectSingleRow($table, $condition, $fieldarray = "", $debug = "") {
        
        $db = $this->getConfiguration();

        if ($fieldarray == "") {
            $f_list = "*";
        } else {
            $f_list = $fieldarray;
        }
        $query = "SELECT $f_list FROM $table WHERE $condition";
        if ($debug == 1) {
            echo $query;
            exit();
        }
        $result = mysqli_query($db, $query);
        if (!$result)
            return 0;
        $record = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $record;
    }

//select all records (return array of records)
    function SelectTable($table, $condition = "", $fieldarray = "", $debug = "") {

        $db = $this->getConfiguration();
        if ($fieldarray == "") {
            $f_list = "*";
        } else {
            $f_list = $fieldarray;
        }
        $query = "SELECT $f_list FROM $table";
        if (!empty($condition))
            $query .= " WHERE  $condition";
        //echo $query;
        if ($debug == 1) {
            echo $query;
        }
        $result = mysqli_query($db, $query);
        print mysqli_error($db);
        while ($result_row = mysqli_fetch_assoc($result)) {
            $record[] = $result_row;
        }
        mysqli_free_result($result);
        return $record;
    }

    function DeleteRecords($table, $condition) {
        
        $db = $this->getConfiguration();

        $query = "DELETE FROM $table WHERE $condition";
        $result = mysqli_query($db, $query);
        if (is_null($result)) {
            return false;
        } else {
            return true;
        }
    }

//add record
    function InsertRecords($table, $data, $debug = "") {
        
        $db = $this->getConfiguration();

        foreach ($data as $key => $value) {
            $field[] = $key;
            if ($value != "now()")
                $values[] = "'$value'";
            else
                $values[] = "$value";
        }
        $f_list = trim(implode(", ", $field));
        $v_list = trim(implode(", ", $values));
        $query = "INSERT INTO $table ( " . "$f_list" . " ) VALUES ( " . "$v_list" . " )";

        if ($debug == 1) {
            echo $query;
        }

        //echo $query;
        $result = mysqli_query($db, $query);
        if (!$result) {
            echo mysqli_error($db);
            return 0;
        }
        return true;
    }

//edit record
    function UpdateRecords($table, $condition, $updata, $debug = "") {
        
        $db = $this->getConfiguration();

        foreach ($updata as $key => $value) {
            if ($value != "now()") {
                $fv[] = "$key = \"" . "$value" . "\"";
            } else {
                $fv[] = "$key = " . "$value" . "";
            }
        }

        $fv_list = trim(implode(", ", $fv));
        $query = "UPDATE $table SET " . "$fv_list" . " WHERE $condition";
        if ($debug == 1) {
            echo $query;
            exit();
        }
        $result = mysqli_query($db, $query);

        //echo $query."<br>";
        if (!mysqli_affected_rows($db)) {
            return 0;
        } else {
            return 1;
        }
    }
    function redirect($url) {
        header('refresh:0;url=' . $url . '');
    }

}

?>