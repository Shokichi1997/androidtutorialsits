<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
if(isset($_GET['lesson_id'])&&isset($_GET['user_id'])&&isset($_GET['score'])){
  $lesson_id = $_GET['lesson_id'];
  $user_id = $_GET['user_id'];
  $score = $_GET['score'];
  $scoreAdd = $score;
  
  include "../lib/db.php";
  include "../lib/functions.php";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid()){
    $sql = "SELECT score FROM PUBLIC.scores WHERE user_id = '$user_id'  AND lesson_id ='$lesson_id'" ;
    $result = $dbconnection->select($sql);
    if($result!==null){
      if(pg_num_rows($result)>0){
        $current_score = null;
        while($data = pg_fetch_object($result)){
          $current_score = $data->score;
          break;
        }
        $scoreAdd = $scoreAdd + $current_score;
        $sql_update = "UPDATE public.scores SET score = '$scoreAdd' WHERE user_id = '$user_id' AND lesson_id = '$lesson_id'";
        $dbconnection->execute($sql_update);
        if($scoreAdd >= Constant::PASS_SCORE){
            checkPassLesson($dbconnection, $user_id,$lesson_id);
        }
        $res = new Result(Constant::SUCCESS , 'Processing request successfully.');
        $res->data = $scoreAdd;
      }
      else{
        $res = new Result(Constant::GENERAL_ERROR , 'Lesson is not open.');
      }
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
