<?php
  namespace StabDex\Utils;  
    
  use Phalcon\Di\Injectable;
  
  
  class Packer extends Injectable {
    public function packPM($pokemon) {
    // generate types and abilities array.
    $types = [];
    foreach($pokemon->types as $type) {
      $types[] = [
                   "Name" => $type->type_name,
                   "Url" => $this->url->get($this->config->url->types . "/" . $type->tpid)
                 ];
    }
    $abilities = [];
    foreach($pokemon->normalAbilities as $ability) {
      $abilities[] = [
                       "isHidden" => false,
                       "Name" => $ability->ability_name,
                       "Url" => $this->url->get($this->config->url->abilities . "/" . $ability->abid)
                     ];
    }
    $hidden_ab = $pokemon->hiddenAbilities->getFirst();
    if ($hidden_ab) {
      $abilities[] = [
                       "isHidden" => true,
                       "Name" => $hidden_ab->ability_name,
                       "Url" => $this->url->get($this->config->url->abilities . "/" . $hidden_ab->abid)
                     ];
    }
    $data = [
      "NID" => $pokemon->nid,
      "Name" => $pokemon->pm_name,
      "Url" => $this->url->get($this->config->url->pokemons . "/" . $pokemon->pmid),
      "Height" => intval($pokemon->height),
      "Weight" => intval($pokemon->weight),
      "HP" => intval($pokemon->htp),
      "Atk" => intval($pokemon->atk),
      "Def" => intval($pokemon->def),
      "SpAtk" => intval($pokemon->sak),
      "SpDef" => intval($pokemon->sdf),
      "Speed" => intval($pokemon->spd),
      "Types" => $types,
      "Abilities" => $abilities,
    ];
    return $data;
    }
    
  }