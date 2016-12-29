<?php
  namespace StabDex\Utils;
  
  
  // Parsing the filter string into a QueryBuilder compatible parameter array.
  class Parser {
    
    public function parse($encoded) {
      $raw = urldecode($encoded);
      return array();
    }
    
  }