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
  $sql = "SELECT user_id FROM public.scores A, public.lesson B WHERE A.lesson_id = B.lesson_id AND user_id = '$user_id' AND B.chapter_id='$chapter_id'";
  $result = $dbconnection->select($sql);
  if($result!==null){
    if(pg_num_rows($result)>0){
      return true;
    }
  }
  return false;
}

function checkPassLesson($dbconnection, $user_id,$lesson_id){
  $sql = "SELECT lesson_id FROM public.lesson WHERE lesson_before = '$lesson_id'";
  $result = $dbconnection->select($sql);
  if($result!==null){
    if(pg_num_rows($result)>0){
      $lesson_id_after = (pg_fetch_object($result))->lesson_id;
      $sql1 = "SELECT lesson_id FROM public.scores WHERE lesson_id = '$lesson_id_after' AND user_id = '$user_id'";
      $result1 = $dbconnection->select($sql1);
      if($result1!==null){
        if(pg_num_rows($result1)==0){
          $sql3 = "INSERT INTO public.scores(user_id,$lesson_id,score) VALUES ('$user_id','$lesson_id_after','0')";
          $dbconnection->execute($sql3);
        }
	 $dbconnection->closeResult($result1);
      }
    }
    $dbconnection->closeResult($result);
  }
}

function getNumLessonOpened($dbconnection,$user_id){
  $sql = "SELECT COUNT(*) AS num_lesson FROM PUBLIC.scores WHERE user_id = '$user_id'";
  $result = $dbconnection->select($sql);
  if($result !== null){
    $num = (pg_fetch_object($result))->num_lesson;
    return $num;
  }
  return 0;
}
function insertDefaultLessonOpen($dbconnection,$user_id){
    $sql = "INSERT INTO scores (user_id,lesson_id,score) VAlUES ('$user_id','1','0')";
    $sql2 = "INSERT INTO scores (user_id,lesson_id,score) VAlUES ('$user_id','2','0')";
    $sql3 = "INSERT INTO scores (user_id,lesson_id,score) VAlUES ('$user_id','3','0')";
    $dbconnection->execute($sql);
    $dbconnection->execute($sql3);
}
function getListLessonItem($dbconnection,$lesson_id){
  $sql = "SELECT lesson_item_id,lesson_item_name,lesson_id FROM public.lesson_item WHERE lesson_id = '$lesson_id' ORDER BY lesson_item_id ASC";
  $result = $dbconnection->select($sql);
   $arr = array();
  if($result!==null){
    while ($data = pg_fetch_object($result)) {
      array_push($arr, $data);
    }
  }
 return $arr;
}
