<?php
  namespace StabDex\Models;
  use Phalcon\Mvc\Model;

  class Pokemons extends Model {
    
    public function getTotal() {
      return $this->htp + $this->atk + $this->def + $this->sak + $this->sdf + $this->spd;
    }
    
    public function initialize() {
      $this->hasManyToMany(
        'pmid',
        'StabDex\\Models\\PokemonsTypes',
        'pmid', 'tpid',
        'StabDex\\Models\\Types',
        'tpid',
        ["alias" => "types", "reusable" => true]
      );
      $this->hasManyToMany(
        "pmid",
        "StabDex\\Models\\PokemonsAbilitiesNormal",
        "pmid", "abid",
        "StabDex\\Models\\Abilities",
        "abid",
        ["alias" => "normalAbilities", "reusable" => true]
      );
      $this->hasManyToMany(
        "pmid",
        "StabDex\\Models\\PokemonsAbilitiesHidden",
        "pmid", "abid",
        "StabDex\\Models\\Abilities",
        "abid",
        ["alias" => "hiddenAbilities", "reusable" => true]
      );
    }
    
    public function jsonSerialize() {
      // generate types and abilities array.
      $di = $this->getDI();
      $ready = [
        "nid" => $this->nid,
        "name" => $this->pm_name,
        "url" => $di->get("url")->get($di->get("pokemonsEP") . "/id/" . $this->pmid),
        "height" => intval($this->height),
        "weight" => intval($this->weight),
        "htp" => intval($this->htp),
        "atk" => intval($this->atk),
        "def" => intval($this->def),
        "sak" => intval($this->sak),
        "sdf" => intval($this->sdf),
        "spd" => intval($this->spd),
        "total" => $this->getTotal(),
        "types" => $this->types,
        "abilities" => $this->normalAbilities,
        "hidden_abilities" => $this->hiddenAbilities,
      ];
      return $ready;
    }
  }