<?php
function getLevelQuestion($dbconnection,$user_id,$lesson_id){
	$sql = "SELECT score FROM public.scores WHERE user_id = '$user_id' AND lesson_id = '$lesson_id'";
	$result = $dbconnection->select($sql);
	if($result!==null){
		if(pg_num_rows($result)>0){
			$score = 1;
			while ($data = pg_fetch_object($result)) {
				score = $data->score;
				break;
			}
			if($score < 5){
				return 1;
			}
			if($score < 8){
				return 2;
			}
			return 3;
		}
		else {
			return 1;
		}
	}else{
		return 1;
	}
}
