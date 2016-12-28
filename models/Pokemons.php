<?php
  namespace StabDex\Models;
  use Phalcon\Mvc\Model;

  class Pokemons extends Model {
    public function initialize() {
      $this->hasManyToMany(
        'pmid',
        'StabDex\\Models\\PokemonsTypes',
        'pmid', 'tpid',
        'StabDex\\Models\\Types',
        'tpid',
        ["alias" => "types"]
      );
      $this->hasManyToMany(
        "pmid",
        "StabDex\\Models\\PokemonsAbilitiesNormal",
        "pmid", "abid",
        "StabDex\\Models\\Abilities",
        "abid",
        ["alias" => "normalAbilities"]
      );
      $this->hasManyToMany(
        "pmid",
        "StabDex\\Models\\PokemonsAbilitiesHidden",
        "pmid", "abid",
        "StabDex\\Models\\Abilities",
        "abid",
        ["alias" => "hiddenAbilities"]
      );
    }
    
    public function jsonSerialize() {
      // generate types and abilities array.
      $di = $this->getDI();
      $ready = [
        "nid" => $this->nid,
        "name" => $this->pm_name,
        "url" => $di->get("url")->get($di->get("pokemonsEP") . "/" . $this->pmid),
        "height" => intval($this->height),
        "weight" => intval($this->weight),
        "hp" => intval($this->htp),
        "atk" => intval($this->atk),
        "def" => intval($this->def),
        "sp_atk" => intval($this->sak),
        "sp_def" => intval($this->sdf),
        "speed" => intval($this->spd),
        "types" => $this->types,
        "abilities" => $this->normalAbilities,
        "hidden_abilities" => $this->hiddenAbilities,
      ];
      return $ready;
    }
  }