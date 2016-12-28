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
    
    public function partial() {
      $di = $this->getDI();
      $output = [
        "name" => $this->type_name,
        "url" => $di->get("url")->get($di->get("typesEP") . "/$this->tpid"),
      ];
      return $output;
    }
    
    public function fullOffensive() {
      $di = $this->getDI();
      $output = [
        "name" => $this->type_name,
        "url" => $di->get("url")->get($di->get("typesEP") . "/$this->tpid"),
        "super_effective" => $this->superAgainst,
        "not_effective" => $this->halfAgainst,
        "no_effect" => $this->noEffectAgainst,
      ];
      return $output;
    }
    
    public function fullDefensive() {
      $di = $this->getDI();
      $output = [
        "name" => $this->type_name,
        "url" => $di->get("url")->get($di->get("typesEP") . "/$this->tpid"),
        "weaknesses" => $this->weakTo,
        "resistances" => $this->resistantTo,
        "immunities" => $this->immuneTo,
      ];
      return $output;      
    }
    
    public function jsonSerialize() {
      return $this->partial();
    }
  }