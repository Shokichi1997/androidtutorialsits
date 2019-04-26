<?php 
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
if(isset($_POST['chapter_id'])&&isset($_POST['user_id'])){
  $chapter_id = $_POST['chapter_id'];
  $user_id = $_POST['user_id'];
  
  include "../lib/db.php";
  include "../lib/functions.php";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid()){

    if(isOpeningChapter($dbconnection,$user_id,$chapter_id)==true || $chapter_id == 1){
      $sql = "SELECT lesson_id,lesson_name,chapter_id,lesson_icon FROM public.lesson WHERE chapter_id = '$chapter_id'";
      $result = $dbconnection->select($sql);
      $arr = array();
      $arr_lesson = array();
      if($result!==null){
        if(pg_num_rows($result)>0){
          while($data = pg_fetch_object($result)){
            array_push($arr_lesson,$data);
          }
        }
        else{
          $res = new Result(Constant::GENERAL_ERROR , 'Lesson is not available.');  
        }
        $sql2 = "SELECT lesson_item_id,lesson_item_name,B.lesson_id,content FROM public.lesson_item A,public.lesson B 
        WHERE A.lesson_id = B.lesson_id AND B.chapter_id = '$chapter_id' ORDER BY lesson_item_id ASC";
        $result2 = $dbconnection->select($sql2);
        $arr_lesson_item = array();
        if($result2!==null){
          if(pg_num_rows($result2)>0){
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
      $res = new Result(Constant::CHAPTER_NOT_OPENED , 'Chapter is not opened.');  
    }
  }
  else{
    $res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
  }
}
else{
      $res = new Result(Constant::INVALID_PARAMETERS, 'Invalid parameters.');
}
echo (json_encode($res,JSON_UNESCAPED_UNICODE));
