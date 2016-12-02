<?php
  namespace StabDex\Models;
  use Phalcon\Mvc\Model;

  class Types extends Model {
    public function initialize() {
      $this->hasManyToMany(
        'tpid',
        'StabDex\\Models\\PokemonsTypes',
        'tpid', 'pmid',
        'StabDex\\Models\\Pokemons',
        'pmid',
        ["alias" => "pokemons"]
      );
      
      // super/weak relations using type_effects_double table.
      $this->hasManyToMany(
        'tpid',
        'StabDex\\Models\\TypeEffectsDouble',
        'atk_tpid', 'def_tpid',
        'StabDex\\Models\\Types',
        'tpid',
        ["alias" => "superAgainst"]
      );
      $this->hasManyToMany(
        'tpid',
        'StabDex\\Models\\TypeEffectsDouble',
        'def_tpid', 'atk_tpid',
        'StabDex\\Models\\Types',
        'tpid',
        ["alias" => "weakTo"]
      );
      // half/resistant relations using type_effects_half table.
      $this->hasManyToMany(
        'tpid',
        'StabDex\\Models\\TypeEffectsHalf',
        'atk_tpid', 'def_tpid',
        'StabDex\\Models\\Types',
        'tpid',
        ["alias" => "halfAgainst"]
      );
      $this->hasManyToMany(
        'tpid',
        'StabDex\\Models\\TypeEffectsHalf',
        'def_tpid', 'atk_tpid',
        'StabDex\\Models\\Types',
        'tpid',
        ["alias" => "resistantTo"]
      );
      // noEffect/immune relations using type_effects_none table.
      $this->hasManyToMany(
        'tpid',
        'StabDex\\Models\\TypeEffectsNone',
        'atk_tpid', 'def_tpid',
        'StabDex\\Models\\Types',
        'tpid',
        ["alias" => "noEffectAgainst"]
      );
      $this->hasManyToMany(
        'tpid',
        'StabDex\\Models\\TypeEffectsNone',
        'def_tpid', 'atk_tpid',
        'StabDex\\Models\\Types',
        'tpid',
        ["alias" => "immuneTo"]
      );
    }
  }