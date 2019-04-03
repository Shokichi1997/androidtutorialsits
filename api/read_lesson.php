<?php 
header('Content-Type: application/json');
include "../lib/data.php";
$result = null;
$res = null;
$inputJSON = file_get_contents('php://input');
$input = json_decode( $inputJSON);
if($input!=null){
  $lesson_item_id = $input->lesson_item_id;
  echo "lesson_item_id = $lesson_item_id";
  include "../lib/db.php";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid()){
    $sql = "SELECT content FROM public.lesson_item WHERE lesson_item_id = '$lesson_item_id'";
    $result = $dbconnection->select($sql);
    if($result!==null){
      if(pg_num_rows($result)>0)
      {
          $content = (pg_fetch_object($result))->content;
          if($content!=null){
            $res->data = $content;
            $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
          }
          else{
            $res = new Result(Constant::GENERAL_ERROR , 'Content of lesson item is not available.');   
          }
          
      }//pg_num_rows($result)>0
      else{
        $res = new Result(Constant::GENERAL_ERROR, 'Lesson item is not exist');
      }
      $dbconnection->closeResult($result);
    }//$result!==null
    else{
      $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
    }
  }//$dbconnection->isValid()
  else{
    $res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
  }
}
else{
    $res = new Result(Constant::INVALID_PARAMETERS, 'Invalid parameters.');
}
echo (json_encode($res));
