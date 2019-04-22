<?php
class Result
{
    public $error;
    public $message;
    public $data;
    public function __construct($error, $message)
    {
        $this->error = $error;
        $this->message = $message;
    }
}
class Constant
{
    const INVALID_PARAMETERS = -2;
    const GENERAL_ERROR = -1;
    const SUCCESS = 0;
    const INVALID_USER = 1;
    const INVALID_PASSWORD = 2;
    const USER_EXIST = 3;
    const EMAIL_EXIST = 4;
    const INVALID_DATABASE = -3;   
}

class Question
{
    public $question_id;
    public $content;
    public $type_qs;
    public $answers;
    public $hint;
    public $level;
    public function __construct($question_id, $content, $type_qs, $hint,$level)
    {
        $this->question_id = $question_id;
        $this->content = $content;
        $this->type_qs = $type_qs;
        $this->hint = $hint;
        $this->level = $level;
    }
}

class Answer
{
    public $answer_id;
    public $answer_content;
    public $result;
    
    public function __construct($answer_id, $answer_content, $result)
    {
        $this->answer_id = $answer_id;
        $this->answer_content = $answer_content;
        $this->result = $result;
    }
}

class Example
{
    public $id;
    public $name;
    public $java_code;
    public $xml_code;
    public $icon;
    
    public function __construct($id,$name,$java_code,$xml_code,$icon)
    {
        $this->id = $id;
        $this->name = $name;
        $this->java_code = $java_code;
        $this->xml_code = $xml_code;
        $this->icon = $icon;
    }
}
