<?php 
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
$inputJSON = file_get_contents('php://input');
$input = json_decode( $inputJSON);
//if(isset($_GET['lesson'])){
if($input!=null){
  $lesson_item_id = $input->lesson_item_id;
  //echo "lesson_item_id = $lesson_item_id";
  //$lesson_item_id = $_GET['lesson'];
  include "../lib/db.php";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid()){
    $sql = "SELECT lesson_item_name,content FROM public.lesson_item WHERE lesson_item_id = '$lesson_item_id'";
    $result = $dbconnection->select($sql);
    if($result!==null){
      if(pg_num_rows($result)>0)
      {
          //default_charset = "utf-8";
          $content = pg_fetch_array($result);
          if($content!=null){
            $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
            $res->data = $content;
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
echo (json_encode($res,JSON_UNESCAPED_UNICODE));
