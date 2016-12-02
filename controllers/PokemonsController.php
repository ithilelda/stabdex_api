<?php
  namespace StabDex\Controllers;
  use Phalcon\Mvc\Controller;
  use StabDex\Models\Pokemons;
  
  
  class PokemonsController extends Controller {
  
  function getAll() {
    $pms = Pokemons::find(["order" => "nid"]);
    $data = [];
    foreach ($pms as $pm) {
      $data[] = $this->packer->packPM($pm);
    }
    echo json_encode($data);
  }
  
  function getName ($name) {
    $phql = "SELECT * FROM StabDex\Models\Pokemons WHERE pm_name LIKE :name: ORDER BY nid, pmid";
    $pms = $this->modelsManager->executeQuery($phql, ["name" => "%" . $name . "%"]);
    $data = [];
    foreach ($pms as $pm) {
      $data[] = $this->packer->packPM($pm);
    }
    echo json_encode($data);
  }
  }