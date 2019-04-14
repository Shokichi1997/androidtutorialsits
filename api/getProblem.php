<?php 
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
if(isset($_GET['lesson_id'])&&isset($_GET['user_id'])){
  include "../lib/db.php";
  $lesson_id = $_GET['lesson_id'];
  $user_id = $_GET['user_id'];
  $dbconnection = new postgresql("");
  if($dbconnection->isValid()){
    include "../lib/functions.php";
    //$level = getLevelQuestion($dbconnection,$user_id,$lesson_id);
    $level = 3;
    $sql = "SELECT question_id,content,type_qs,hint,level FROM PUBLIC.question WHERE lesson_id = '$lesson_id' AND level <= '$level' order by random() limit 1" ;
    $result = $dbconnection->select($sql);
    $question = null;
    if($result!==null){
      if(pg_num_rows($result)>0){
        while($data = pg_fetch_object($result)){
          $question = new Question($data->question_id,$data->content,$data->type_qs,$data->hint,$data->level);
          break;
        }
          $question_id = $question->question_id;
          $sql_answer = "SELECT answer_id,answer_content,result FROM public.answer WHERE question_id = '$question_id' order by random()";
          $result_answer = $dbconnection->select($sql_answer);
          if($result_answer!==null){
            if(pg_num_rows($result_answer)>0){
              $arr_answers = array();
              $answer = null;
              while($data = pg_fetch_object($result_answer)){
                $answer= new Answer($data->answer_id,$data->answer_content,$data->result);
                array_push($arr_answers,$answer);
              }
              $question->answers = $arr_answers;
            }
            //pg_num_rows($result_answer)>0
            else{
              $res = new Result(Constant::GENERAL_ERROR, 'Question do not have answers.');
            }
          }
          //$result_answer!==null
          else{
            $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
          }
        $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
        $res->data = $question;
     //pg_num_rows($result)>0 
      }
      else{
        $res = new Result(Constant::GENERAL_ERROR, 'This lesson do not have questions.');
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
