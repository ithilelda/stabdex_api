<?php
  namespace StabDex\Models;
  use Phalcon\Mvc\Model;

  class Abilities extends Model {
    public function initialize() {
      $this->hasManyToMany(
        "abid",
        "StabDex\\Models\\PokemonsAbilitiesNormal",
        "abid", "pmid",
        "StabDex\\Models\\Pokemons",
        "pmid",
        ["alias" => "pokemonsWithNormal"]
      );
      $this->hasManyToMany(
        "abid",
        "StabDex\\Models\\PokemonsAbilitiesHidden",
        "abid", "pmid",
        "StabDex\\Models\\Pokemons",
        "pmid",
        ["alias" => "pokemonsWithHidden"]
      );
    }
    
    public function jsonSerialize() {
      $di = $this->getDI();
      $ready = [
        "name" => $this->ability_name,
        "url" => $di->get("url")->get($di->get("abilitiesEP") . "/" . $this->abid),
      ];
      return $ready;
    }
  }