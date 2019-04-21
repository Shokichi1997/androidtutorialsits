<?php 
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
$inputJSON = file_get_contents('php://input');
$input = json_decode( $inputJSON);
if($input!=null){
  $example_id = $input->example_id;
  include "../lib/db.php";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid()){
    $sql = "SELECT java_code,xml_code FROM public.examples WHERE id = '$example_id'";
    $result = $dbconnection->select($sql);
    if($result!==null){
      if(pg_num_rows($result)>0)
      {
          //default_charset = "utf-8";
          $content = (pg_fetch_object($result));
          if($content!=null){
            $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
            $res->data = $content;
          }
          else{
            $res = new Result(Constant::GENERAL_ERROR , 'Content of lesson item is not available.');   
          }
          
      }//pg_num_rows($result)>0
      else{
        $res = new Result(Constant::GENERAL_ERROR, 'Example is not exist');
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
