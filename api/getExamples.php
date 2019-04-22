<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
include "../lib/db.php";
$dbconnection = new postgresql("");
if($dbconnection->isValid()){
    $sql = "SELECT id,name,icon FROM PUBLIC.examples";
    $result = $dbconnection->select($sql);
    $res_exam = array();
    if($result!==null){
      	if(pg_num_rows($result)>0){
		while($data = pg_fetch_object($result)){
	        	array_push($res_exam, new ExampleSimple($data->id,$data->name,$data->icon));
	        }	          
	        $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
	        $res->data = $res_exam;
     	//pg_num_rows($result)>0 
      	}
      	else{
        	 $res = new Result(Constant::GENERAL_ERROR, 'Examples data not found.');
      	}
    }
    else{
       $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
    }
}
//$dbconnection->isValid()
else{
	$res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
}
echo (json_encode($res,JSON_UNESCAPED_UNICODE));
