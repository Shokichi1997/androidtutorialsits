<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
if(isset($_GET['lesson_id'])&&isset($_GET['user_id'])){
  $lesson_id = $_GET['lesson_id'];
  $user_id = $_GET['user_id'];
  
  include "../lib/db.php";
  include "../lib/functions.php";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid()){
    $sql = "SELECT score FROM PUBLIC.scores WHERE user_id = '$user_id'  AND lesson_id ='$lesson_id'" ;
    $result = $dbconnection->select($sql);
    $arr = array();
    if($result!==null){
      $num = getNumLessonOpened($dbconnection,$user_id);
      if($num == 0){
        insertDefaultLessonOpen($dbconnection,$user_id);
        $num = 3;
      }
      array_push($arr,$num);
      if($lesson_id == 1 || $lesson_id == 2 || $lesson_id = 3 || pg_num_rows($result)>0){
        array_push($arr, 1); //1: open
      }
      else{
        array_push($arr, 0); //1: not open
      }
      $res = new Result(Constant::SUCCESS , 'Processing request successfully.');
      $res->data = $arr;
      $dbconnection->closeResult($result);
    }
    else{
       $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
    }
    $dbconnection->close();
  }
  //$dbconnection->isValid()
  else{
      $res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
  }
  
}
else{
  $res = new Result(Constant::INVALID_PARAMETERS,'Invalid parameters');  
}
echo (json_encode($res,JSON_UNESCAPED_UNICODE));
