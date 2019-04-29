
<?php
header('Content-Type: application/json');
include "../lib/data.php";
$res    = null;
$result =null;

if(isset($_POST['user_id']))
{
  $user_id=$_POST['user_id'];
  $password_new=$_POST['password_new'];
  
  //connect database
  include ('../lib/db.php');
  //check acount is exsit
 $sql_find_user = "SELECT * FROM public.user WHERE user_id ='$user_id' ";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid())
  {
     $result = $dbconnection->select($sql_find_user);
      if($result!==null){
        if(pg_num_rows($result)!=0){  
            $sql_update_user = "UPDATE  public.user
                                SET password='$password_new'
                                WHERE user_id='$user_id' ";
            $dbconnection->execute($sql_update_user);
            //update successfully => return user infor 
            $user=null;
            $res->data=user;//set data for res
            $res = new Result(Constant::SUCCESS,'Update successfully');
        }// Excute sql update info student
        else{
           $res = new Result(Constant::USER_EXIST , 'User is not exist');
        }// User is not exist
        $dbconnection->closeResult($result);
      }
      else{
        $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
      }
    $dbconnection->close();
  }
  else{ 
    $res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
    }
  
 }
else{
    $res = new Result(Constant::INVALID_PARAMETERS, 'Invalid parameters.');
}
echo (json_encode($res));
?>
