<?php
  namespace StabDex\Utils;
  
  
  class Packer {
    public function packPage($page, $url, $queries) {
      $output = [
        "limit" => $queries["limit"],
        "items" => $page->total_items,
        "pages" => $page->total_pages,
        "current" => $url . "?" . http_build_query($queries) . "&page=$page->current",
        "first" => $url . "?" . http_build_query($queries) . "&page=1",
        "previous" => $url . http_build_query($queries) . "&page=$page->before",
        "next" => $url . "?" . http_build_query($queries) . "&page=$page->next",
        "last" => $url . "?" . http_build_query($queries) . "&page=$page->last",
        "data" => $page->items,
      ];
      return $output;
    }

  }