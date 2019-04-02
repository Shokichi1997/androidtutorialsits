<?php
header('Content-Type: application/json');
//Test
$res = null;
if (isset($_GET["username"])) {
    $username = $_GET["username"];
    $res = $username;
} else {
    $res = "loi=i";
}
echo (json_encode($res));
