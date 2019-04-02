<?php
header('Content-Type: application/json');
include "../lib/data.php";
//Test
$res = null;
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["email"];
    
    $sql = "SELECT * FROM public.user WHERE email ='$email'";
    // ket noi database
    include "../lib/db.php";
    $dbconnection = new postgresql("");
    if($dbconnection->$dbconnection->isValid())
    {
      $result = $dbconnection->select($sql);
      if ($result !== null) {
        if (pg_num_rows($result) > 0) {
            //user exist, check password
            $dbpassword = null;
            $user = null;
            while ($data = pg_fetch_object($result)) {
                $dbpassword = $data->pass_word;
                $user = $data;
                break;
            }
            if ($dbpassword !== null) {
                if (strcasecmp($dbpassword, $password) == 0) {
                    $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');
                    unset($user->pass_word);
                    $res->data = $user;
                } else {
                    $res = new Result(Constant::INVALID_PASSWORD, 'Password is not matching.');
                }
            } else {
                $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
            }
        } else {
            $res = new Result(Constant::INVALID_USER, 'User is not exist');
        }
        $dbconnection->closeResult($result);
      } else {
          $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
      }
      $dbconnection->close();
    }//$dbconnection->$dbconnection->isValid()
    else
    {
      $res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
    }
} else {
    $res = new Result(Constant::INVALID_PARAMETERS, 'Invalid parameters.');
}
echo (json_encode($res));
