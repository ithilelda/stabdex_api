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
  }