<?php
  if (!file_exists(__DIR__ . "/" . $_SERVER["REQUEST_URI"])) {
    preg_match("/^([^\?#]*)/", $_SERVER["REQUEST_URI"], $matches);
    $_GET["_url"] = $matches[1];
  }

  return false;
