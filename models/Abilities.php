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
  }