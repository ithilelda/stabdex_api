<?php
  namespace StabDex\Utils;
  
  
  // Tokenize the input string into an array of tokens ready to be processed by the parser.
  class Lexer {
    private static $_terminals = [
      "/^[a-zA-Z]\w*/" => "T_IDENTIFIER",
      "/^\d+/" => "T_INTEGER",
      "/^[\+\-\*\/]/" => "T_OPERATOR",
      "/^(<(=)?|>(=)?|=|!=)/" => "T_COMPARATOR",
      "/^[;\|]/" => "T_SEPARATOR",
      "/^[~\$]/" => "T_JOINER",
      "/^\(/" => "T_LEFT_PAREN",
      "/^\)/" => "T_RIGHT_PAREN"
    ];

    public static function tokenize($raw) {
      $offset = 0;
      while ($offset < strlen($raw)) {
        $subject = substr($raw, $offset);
        $found = false;
        foreach (static::$_terminals as $pattern => $name) {
          if (preg_match($pattern, $subject, $matches)) {
            $tokens[] = ["token" => $matches[0], "name" => $name];
            $offset += strlen($matches[0]);
            $found = true;
            break;
          }
        }
        if(!$found) throw new \Exception("Lexer error. Unrecognized token $subject at $offset.");
      }
      return $tokens;
    }
    
  }