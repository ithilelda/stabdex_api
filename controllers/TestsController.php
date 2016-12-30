<?php
  namespace StabDex\Controllers;
  use Phalcon\Mvc\Controller;
  use StabDex\Utils\Lexer;
  
  
  class TestsController extends Controller {
    // test shows that direct url input is safely encoded. Then by using rawurldecode, we can avoid replacing "+" with spaces.
    function lexerTest1($str) {
      echo "<p>$str</p>";
      $str = rawurldecode($str);
      $tokens = Lexer::tokenize($str);
      print_r($tokens);
    }
    // Query strings retrieved by request service is already decoded. We need to replace the spaces with "+".
    // My small language does not allow any white spaces, so this replacement should not alter the meaning of the user input.
    function lexerTest2() {
      $str = $this->request->getQuery("query");
      echo "<p>$str</p>";
      $str = str_replace(" ", "+", $str);
      $tokens = Lexer::tokenize($str);
      return json_encode($tokens);
    }
    
    // efficiency test. The language is small, so it shouldn't be a bottleneck. The performance in relationship with string length is O(n) roughly. to prevent malicious user from halting the server,
    // I will implement string length limit in the production environment.
    function lexerTest3() {
      $str = $this->request->getQuery("query");
      $str = str_replace(" ", "+", $str);
      for ($i=0;$i<10000;$i++)
        $tokens = Lexer::tokenize($str);
      return json_encode($tokens);
    }
  }