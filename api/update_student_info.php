
<?php
header('Content-Type: application/json');
include "../lib/data.php";
$res    = null;
$result =null;

if(isset($_POST['user_id']))
{
	echo "string";
  
 }
else{
    $res = new Result(Constant::INVALID_PARAMETERS, 'Invalid parameters.');
}
echo (json_encode($res));
?>
