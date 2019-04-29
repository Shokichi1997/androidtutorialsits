
<?php
header('Content-Type: application/json');
include "../lib/data.php";
$res    = null;
$result = null;
if(isset($_POST['student_code'])){
  $student_code = $_POST['student_code'];
  $password     = "8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92";
  $role         =  3; //default role 3(role is student)
  $full_name    = "anymouse";
  $email        = $_POST['email'];    
  //connect database
  include ('../lib/db.php');
  //check acount is exsit
  $sql_find_user = "SELECT * FROM public.user WHERE student_code = '$student_code'";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid())
  {
     $result = $dbconnection->select($sql_find_user);
      if($result!==null){
        if(pg_num_rows($result)==0){  
            $sql_dk = "INSERT INTO public.user(full_name,password,email,role,student_code,date_create)
            values ('$full_name','$password','$email','$role','$student_code',CURRENT_DATE)";
            $dbconnection->execute($sql_dk);
            //Registered successfully => return user infor 
            $res = new Result(Constant::SUCCESS,'Registered successfully');
        }// Excute sql add student
        else{
           $res = new Result(Constant::USER_EXIST , 'User is exist');
        }// User is exist
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
