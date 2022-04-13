<?php
  class QuizService extends Model
  {
    public static function markQuiz()
    {

    }

    public static function submitQuiz()
    {
      if(isset($_POST["SUBMITTED"]))
      {

      }
      else
      {
        return false;
      }
    }

    private static function generateQuizForm(array $qObj)
    {
      $html = "";

      $id = $qObj["QUIZID"];
      $questions = $qObj["QUIZDATA"];
      foreach($questions as $question)
      {
        $html .= self::generateQuizQuestion($question);
      }

      return $html;
    }

    private static function generateQuizQuestion(array $question)
    { 
      ob_start();
      $html = "";
      $type = $question["TYPE"];
      $questionText = $question["QUESTION_TEXT"];
      $answers = $question["ANWSERS"];
      
      foreach($answers as $answer)
      {
        $html .= self::generateQuizRadio($answer);
      }
      return ob_get_clean();
    }

    private static function generateQuizRadio(array $answer)
    {
      ob_start();
      include "./Quiz/quizForm.Answer.php";
      return ob_get_clean();
      
    }

    public static function displayQuiz(string $jsonFile)
    {
      $usableObject = json_decode($jsonFile, true);
      print_r($usableObject);
      echo("<br>");
      echo("<br>" . "NAME: " . $usableObject["QUIZID"]);
      echo("<br>" . "TYPE: " . $usableObject["QUIZDATA"][0]["TYPE"]);
      echo("<br>" . "QUESTION: " . $usableObject["QUIZDATA"][0]["QUESTION_TEXT"]);
      
      echo("<br>" . "ANWSER-01-TEXT: " . $usableObject["QUIZDATA"][0]["ANWSERS"][0]["TEXT"]);
      echo("<br>" . "ANWSER-01-MARKS: " . $usableObject["QUIZDATA"][0]["ANWSERS"][0]["MARKS"]);

      echo("<br>" . "ANWSER-02-TEXT: " . $usableObject["QUIZDATA"][0]["ANWSERS"][1]["TEXT"]);
      echo("<br>" . "ANWSER-02-MARKS: " . $usableObject["QUIZDATA"][0]["ANWSERS"][1]["MARKS"]);
    }
  }
?>