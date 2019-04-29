
<?php
header('Content-Type: application/json');
include "../lib/data.php";
$res    = null;
$result =null;

if(isset($_POST['user_id']))
{
  $user_id=$_POST['user_id']
  
  //connect database
  include ('../lib/db.php');
  //check acount is exsit
  $sql_find_user = "SELECT * FROM public.user WHERE user_id = $user_id";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid())
  {
  	echo "string";
  }
  else{ 
    //$res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
    echo "loi";
   }
  
 }
else{
    $res = new Result(Constant::INVALID_PARAMETERS, 'Invalid parameters.');
}
echo (json_encode($res));
?>
