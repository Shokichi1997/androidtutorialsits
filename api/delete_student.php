<?php 
header('Content-Type: application/json');
//error_reporting(E_ALL);
include "../lib/data.php";
$res = null;

if(isset($_POST['user_id'])){
  $user_id = $_POST['user_id'];
  include "../lib/db.php";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid()){
    //Delete student form table user
         $sql="DELETE FROM public.User WHERE user_id='$user_id' ";
         $result = $dbconnection->execute($sql);
         $res=new Result(Constant::SUCCESS,'Excute successfully');
  }//$dbconnection->isValid()
  else{
    $res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
  }
}//isset($_POST['user_id'])))
else{
  $res = new Result(Constant::INVALID_PARAMETERS, 'Invalid parameters.');
}
echo (json_encode($res));
?>
