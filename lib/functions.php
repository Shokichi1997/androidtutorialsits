<?php
function getLevelQuestion($dbconnection,$user_id,$lesson_id){
	$sql = "SELECT score FROM public.scores WHERE user_id = '$user_id' AND lesson_id = '$lesson_id'";
	$result = $dbconnection->select($sql);
	if($result!==null){
		if(pg_num_rows($result)>0){
			$score = 1;
			while ($data = pg_fetch_object($result)) {
				$score = $data->score;
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

function getLessonInfo($dbconnection, $lesson_id){
	$sql = "SELECT lesson_id,lesson_name,chapter_id,lesson_icon FROM public.lesson WHERE lesson_id = '$lesson_id'";
	$result = $dbconnection->select($sql);
	if($result!==null){
		if(pg_num_rows($result)>0){
			$les = pg_fetch_object($result);
			return $les;
		}
	}
	return null;
}
function isOpeningChapter($dbconnection,$user_id,$chapter_id) {
  $sql = "SELECT user_id FROM public.scores WHERE user_id = '$user_id' AND chapter_id='$chapter_id'";
  $result = $dbconnection->select($sql);
  if($result!==null){
    if(pg_num_rows($result)>0){
      return true;
    }
  }
  return false;
}
