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
      $filter = $this->request->getQuery("filter");
      $supported_queries["limit"] = $limit;
      $filters = [];
      try {
        if ($filter) {
          $supported_queries["filter"] = $filter;
          $filters = $this->packer->parse($filter);
        }
        
        $params = [
          "models" => array("StabDex\\Models\\Pokemons"),
          "order" => array("nid","pmid")
        ];
        $builder = $this->modelsManager->createBuilder(array_merge($params, $filters));
        $paginator = new PaginatorQueryBuilder(
          [
            "builder" => $builder,
            "limit" => $limit,
            "page" => $page,
          ]
        );
        $page = $paginator->getPaginate();
        echo json_encode($this->packer->packPage($page, $this->url->get($this->pokemonsEP), $supported_queries), JSON_UNESCAPED_SLASHES);
      }
      catch (\Exception $e){
        $this->response->setStatusCode(400, "Bad Request");
        $this->response->sendHeaders();
        echo $e->getMessage();
      }
    }
    function getID($id) {
      $pm = Pokemons::findFirst("pmid = $id");
      if ($pm) {
        return json_encode($pm,JSON_UNESCAPED_SLASHES);
      }
      else {
        $this->response->setStatusCode(404, "Not Found");
        $this->response->sendHeaders();
        echo "the pokemon does not exist!";
      }
    }
    function getName($name) {
      $pm = Pokemons::findFirst("pm_name = '$name'");
      if ($pm) {
        return json_encode($pm,JSON_UNESCAPED_SLASHES);
      }
      else {
        $this->response->setStatusCode(404, "Not Found");
        $this->response->sendHeaders();
        echo "the pokemon does not exist!";
      }
    }
    
    function getStats($stat) {
      $pms = Pokemons::find();
      foreach ($pms as $pm) {
        $data[] = ["pmid" => intval($pm->pmid), "data" => intval($pm->$stat)];
      }
      echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
  }