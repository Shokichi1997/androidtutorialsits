<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
include "../lib/db.php";
if(isset($_GET["user_id"])){
  $user_id=$_GET["user_id"];
 $dbconnection = new postgresql("");
if($dbconnection->isValid()){
    $sql = "SELECT scores.lesson_id,lesson.lesson_name,scores.score FROM scores INNER JOIN lesson ON scores.lesson_id=lesson.lesson_id WHERE scores.user_id='$user_id'";
    $result = $dbconnection->select($sql);
    $res_lesson = array();
    if($result!==null){
        if(pg_num_rows($result)>0){
          while($data = pg_fetch_object($result)){
            array_push($res_lesson, $data);
          }           
          $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
          $res->data = $res_lesson;
      //pg_num_rows($result)>0 
        }
        else{
           $res = new Result(Constant::GENERAL_ERROR, 'Lesson data not found.');
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
}else{
 $res = new Result(Constant::INVALID_PARAMETERS, 'Invalid parameters.');
}

echo (json_encode($res,JSON_UNESCAPED_UNICODE));
