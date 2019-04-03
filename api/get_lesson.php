<?php 
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
include "../lib/db.php";
$dbconnection = new postgresql("");
if($dbconnection->isValid()){
  $sql = "SELECT lesson_id,lesson_name,chapter_id,lesson_icon FROM public.lesson";
  $result = $dbconnection->select($sql);
  $arr = array();
  $arr_lesson = array();
  if($result!==null){
    if(pg_num_row()>0){
      while($data = pg_fetch_object($result)){
        array_push($arr_lesson,$data);
      }
    }
    else{
      $res = new Result(Constant::GENERAL_ERROR , 'Lesson is not available.');  
    }
    
    $sql2 = "SELECT lesson_item_id,lesson_item_name,lesson_id,conten FROM public.leson_item";
    $result2 = $dbconnection->select($sql2);
    $arr_lesson_item = array();
    if($result2!==null){
      if(pg_num_row($result2)>0){
        while($data = pg_fetch_object($result2)){
          array_push($arr_lesson_item,$data);
        }
        
        $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
        array_push($arr,$arr_lesson);
        array_push($arr,$arr_lesson_item);
        $res->data = $arr;
      }
      else{
        $res = new Result(Constant::GENERAL_ERROR , 'Lesson item is not available.');  
      }
    }
    else{
      $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
    }
  }
  else{
     $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
  }
  
}
  else{
    $res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
  }
  
echo (json_encode($res,JSON_UNESCAPED_UNICODE));
