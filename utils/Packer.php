<?php
  namespace StabDex\Utils;
  
  
  class Packer {
    public function packPage($page, $url, $queries) {
      $output = [
        "limit" => $queries["limit"],
        "items" => $page->total_items,
        "pages" => $page->total_pages,
        "current" => $page->current,
        "first" => $url . "?" . http_build_query($queries) . "&page=1",
        "previous" => $url . http_build_query($queries) . "&page=$page->before",
        "next" => $url . "?" . http_build_query($queries) . "&page=$page->next",
        "last" => $url . "?" . http_build_query($queries) . "&page=$page->last",
        "data" => $page->items,
      ];
      return $output;
    }
    
    public function parse($filter) {
      $filters = explode(";", $filter);
      if (count($filters) > 10) throw new \Exception("More than 10 expressions were provided in the filter string.");
      foreach($filters as $ex) {
        if (preg_match("/^(\w+)(<(?:=)?|>(?:=)?|=|!=)(\d+)/", $ex, $matches)) {
          $conditions[] = "$matches[1] $matches[2] $matches[3]";
        }
      }
      $condition = implode(" AND ", $conditions);
      return array("conditions" => $condition);
    }

  }