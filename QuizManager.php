<?php
require_once('Manager.php');
class QuizManager extends Manager{
    public function getAllQuestions($name){
        $questionList = [];
        $q = $this->_db->prepare('SELECT question, opt1, opt2, opt3, opt4 FROM quiz');
        while($data = $q->fetch(PDO::FETCH_ASSOC)){
            $questionList[] = new Quiz($data);
        }

        return $questionList;
    }
}