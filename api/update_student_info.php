
<?php
header('Content-Type: application/json');
include "../lib/data.php";
$res    = null;
$result =null;

if(isset($_POST['user_id']))
{
 
  //connect database
  include ('../lib/db.php');
  //check acount is exsit
  $sql_find_user = "SELECT * FROM public.user WHERE user_id = '$user_id'";
  echo "string";
  
  $dbconnection = new postgresql("");
  
  
 }
else{
    $res = new Result(Constant::INVALID_PARAMETERS, 'Invalid parameters.');
}
echo (json_encode($res));
?>
