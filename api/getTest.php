<?php 
header('Content-Type: application/json; charset=utf-8');
include "../lib/data.php";
$result = null;
$res = null;
if(isset($_GET['lesson_id'])){
  include "../lib/db.php";
  $lesson_id = $_GET['lesson_id'];

  $dbconnection = new postgresql("");
  if($dbconnection->isValid()){
    $sql = "SELECT question_id,content,type_qs FROM PUBLIC.question WHERE lesson_id = '$lesson_id'  order by random() limit 10" ;
    $result = $dbconnection->select($sql);
    $arr_question = array();
    if($result!==null){
      if(pg_num_rows($result)>0){
        while($data = pg_fetch_object($result)){
          $question = new ($data->question_id,$data->content,$data->type_qs);
          array_push($arr_question,$question);
        }
        
//         foreach ($arr_question as $qs) {
//           $question_id = $qs->question_id;
//           $sql_answer = "SELECT answer_id,answer_content,result FROM public.answer WHERE question_id = '$question_id' order by random()";
//           $result_answer = $dbconnection->select($sql_answer);
//           if($result_answer!==null){
//             if(pg_num_rows($result_answer)>0){
//               $arr_answers = array();
//               $answer = null;
//               while($data = pg_fetch_object($result_answer)){
//                 $answer->answer_id = $data->answer_id;
//                 $answer->answer_content = $data->answer_content;
//                 $answer->result = $data->result;
//                 array_push($arr_answers,$answer);
//               }
//               $qs->answers = $arr_answers;
//             }
//             //pg_num_rows($result_answer)>0
//             else{
//               $res = new Result(Constant::GENERAL_ERROR, 'Question do not have answers.');
//             }
//           }
//           //$result_answer!==null
//           else{
//             $res = new Result(Constant::GENERAL_ERROR, 'There was an error while processing request. Please try again later.');
//           }
//         }
//         $res = new Result(Constant::SUCCESS, 'Operation complete successfully.');   
//         $res->data = $arr_question;
//      //pg_num_rows($result)>0 
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
