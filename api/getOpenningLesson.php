<?php 
	header('Content-Type: application/json; charset=utf-8');
	include "../lib/data.php";
	$result = null;
	$res = null;
	if(isset($_GET['user_id'])){
		include "../lib/db.php";
	  	$user_id = $_GET['user_id'];
	  	$dbconnection = new postgresql("");
	  	if($dbconnection->isValid()){
	    $sql = "SELECT lesson_id FROM PUBLIC.scores WHERE user_id = '$user_id'";
	    $result = $dbconnection->select($sql);
	    $res_lesson = array();
	    if($result!==null){
	    	$lesson_id = null;
	      	if(pg_num_rows($result)>0){
	      		include "../lib/functions.php";
		        while($data = pg_fetch_object($result)){
		        	$lesson_id = $data->lesson_id;
		        	$lesson =  getLessonInfo($dbconnection,$lesson_id);
		        	if($lesson!=null){
		        		array_push($res_lesson, $lesson);
		        	}
		        }	          
		        $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
		        $res->data = $res_lesson;
	     	//pg_num_rows($result)>0 
	      	}
	      	else{
	        	 $res = new Result(Constant::GENERAL_ERROR, 'User dont have lesson.');
	      	}
	    }
	    else{
	       $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
	    }
	}
	//$dbconnection->isValid()
	else{
    	$res = new Result(Constant::INVALID_DATABASE , 'Database is invalid.');  
	}
}
else{
	$res = new Result(Constant::INVALID_PARAMETERS,'Invalid parameters');  
}
echo (json_encode($res,JSON_UNESCAPED_UNICODE));
