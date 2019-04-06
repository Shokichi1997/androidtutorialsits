
<?php
header('Content-Type: application/json');
include "../lib/data.php";
//Lấy data từ client
$res = null;
if(isset($_POST['email'])&&isset($_POST['full_name'])&&isset($_POST['password'])){
  $email = $_POST['email'];
  $full_name = $_POST['full_name'];
  $password = $_POST['password'];
  $role = false; //mac dinh 
  
  //Kết nối database
  include ('../lib/db.php');
  //Kiểm tra tài khoản này có tồn tại chưa
  $sql_user = "SELECT * FROM public.user WHERE email = '$email'";
  $dbconnection = new postgresql("");
  if($dbconnection->isValid())
  {
     $result = $dbconnection->select($sql_user);
      if($result!==null){
        if(pg_num_rows($result)==0){
            $sql_dk = "INSERT INTO public.user(full_name,email,password,role,date_create)
            values ('$fullname','$email','$password','$role',CURRENT_DATE)";
            $dbconnection->execute($sql_dk);

            //Registered successfully => return user infor 
            $user = null;
            $user->full_name = $full_name;
            $user->email = $email;
            $user->role = $role;
            $user->date_create = CURRENT_DATE;

            $res = new Result(Constant::SUCCESS,'Registered successfully');
            $res->data = $user;
          }
        }
        else{
           $res = new Result(Constant::USER_EXIST , 'User is exist');
        }
        $dbconnection->closeResult($result);
      }
      else{
        $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
      }
      $dbconnection->close();
  }
  else
  { 
    $res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
  }
 } else {
    $res = new Result(Constant::INVALID_PARAMETERS, 'Invalid parameters.');
}
echo (json_encode($res));
?>
