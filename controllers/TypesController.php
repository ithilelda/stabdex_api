<?php
  namespace StabDex\Controllers;
  use Phalcon\Mvc\Controller;
  use StabDex\Models\Types;
  
  
  class TypesController extends Controller {
    
    function getAll() {
      $types = Types::find(["order" => "tpid"]);
      $data = [];
      foreach($types as $type) {
        $data[] = $type->fullOffensive();
      }
      return json_encode($data,JSON_UNESCAPED_SLASHES);
    }
    
    function getName ($name) {
      $type = Types::findFirst("type_name = '$name'");
      echo "<p>", $type->type_name, "</p>";
      echo "<p>super effective:";
      foreach($type->superAgainst as $se) {
        echo " ", $se->type_name;
      }
      echo "</p><p>not so effective:";
      foreach($type->halfAgainst as $he) {
        echo " ", $he->type_name;
      }
      echo "</p><p>no effect:";
      foreach($type->noEffectAgainst as $ne) {
        echo " ", $ne->type_name;
      }
      echo "</p><p>weak to:";
      foreach($type->weakTo as $wt) {
        echo " ", $wt->type_name;
      }
      echo "</p><p>resistant to:";
      foreach($type->resistantTo as $rt) {
        echo " ", $rt->type_name;
      }
      echo "</p><p>immune to:";
      foreach($type->immuneTo as $it) {
        echo " ", $it->type_name;
      }
      echo "</p>";
    }
  }