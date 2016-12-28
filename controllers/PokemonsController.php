<?php
  namespace StabDex\Controllers;
  use Phalcon\Mvc\Controller;
  use StabDex\Models\Pokemons;
  use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
  
  
  class PokemonsController extends Controller {
  
    // Handlers for retrieving pm data.
    function getAll() {
      $page = $this->request->getQuery("page", "int", 1);
      $limit = $this->request->getQuery("limit", "int", 20);
      $pms = $this->modelsManager->createBuilder()
        ->from("StabDex\\Models\\Pokemons")
        ->orderBy(array("nid","pmid"));
      $paginator = new PaginatorQueryBuilder(
        [
          "builder" => $pms,
          "limit" => $limit,
          "page" => $page,
        ]
      );
      echo json_encode($this->packer->packPage($paginator->getPaginate(), $limit, $this->url->get($this->pokemonsEP)),JSON_UNESCAPED_SLASHES);
    }
    function getID($id) {
      $pm = Pokemons::findFirst("pmid = $id");
      if ($pm) {
        return json_encode($pm,JSON_UNESCAPED_SLASHES);
      }
      else {
        $this->response->setStatusCode(404, "Not Found");
        $this->response->sendHeaders();
      }
    }
    function getName ($name) {
      $pm = Pokemons::findFirst("pm_name = '$name'");
      if ($pm) {
        return json_encode($pm,JSON_UNESCAPED_SLASHES);
      }
      else {
        $this->response->setStatusCode(404, "Not Found");
        $this->response->sendHeaders();
      }
    }
    
    // Summary handlers.
    // This returns a grand summary of queried stat. TODO: cache result.
    function getSummary($stat) {
      $metadata = $this->metadata->getAttributes(Pokemons::findFirst());
      if (in_array($stat, $metadata)) {
        $pms = Pokemons::find(["column" => $stat]);
        foreach ($pms as $pm) {
          $data[] = $pm->$stat;
        }
        $summary = $this->stats->summarize($stat, $data);
        echo json_encode($summary, JSON_UNESCAPED_SLASHES);
      }
      else {
        $this->response->setStatusCode(404, "Not Found");
        $this->response->sendHeaders();
      }
    }
        
  }