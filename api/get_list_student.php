    
<?php
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
include "../lib/db.php";
$dbconnection = new postgresql("");
if($dbconnection->isValid()){
  $sql = "SELECT * FROM public.user";
  $result = $dbconnection->select($sql);
  $arr = array();
  if($result!==null){
    if(pg_num_rows($result)>0){
      while($data = pg_fetch_object($result)){
        array_push($arr,$data);
      }
      $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
      $res->data = $arr;
    }
    else{
      $res = new Result(Constant::GENERAL_ERROR , 'Lesson is not available.');  
    }
  }
  else{
     $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
  }
}
else{
    $res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
}
// JSON_UNESCAPED_UNICODE: doc tieng viet
echo (json_encode($res,JSON_UNESCAPED_UNICODE))