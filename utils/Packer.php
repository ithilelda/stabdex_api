<?php
  namespace StabDex\Utils;
  
  
  class Packer {
    public function packPage($page, $limit, $urlBase) {
      $output = [
        "limit" => $limit,
        "items" => $page->total_items,
        "pages" => $page->total_pages,
        "current" => $urlBase . "?limit=$limit&page=$page->current",
        "first" => $urlBase . "?limit=$limit&page=1",
        "previous" => $urlBase . "?limit=$limit&page=$page->before",
        "next" => $urlBase . "?limit=$limit&page=$page->next",
        "last" => $urlBase . "?limit=$limit&page=$page->last",
        "data" => $page->items,
      ];
      return $output;
    }

  }