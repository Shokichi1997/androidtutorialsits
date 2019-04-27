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
    if($chapter_id == 1 || $chapter_id == 2 || isOpeningChapter($dbconnection,$user_id,$chapter_id)==true){
      $sql = "SELECT lesson_id,lesson_name,chapter_id,lesson_icon FROM public.lesson WHERE chapter_id = '$chapter_id'";
      $result = $dbconnection->select($sql);
      $arr_lesson = array();
      if($result!==null){
        if(pg_num_rows($result)>0){
          while($data = pg_fetch_object($result)){
            $arr_lesson_item = array();
            //$arr_lesson_item = getListLessonItem($dbconnection,$data->lesson_id){
            //$lesson = new Lesson ($data->lesson_id,$data->lesson_name,$data->chapter_id,$data->lesson_icon,$arr_lesson_item);
            //array_push($arr_lesson, $lesson);
          }
          $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
          $res->data = $arr_lesson;
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

