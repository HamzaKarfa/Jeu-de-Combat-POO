<?php

class Magicien extends Personnage
{
    protected $type;

    
    
  public function frapper(Personnage $perso)
    {
      if($perso->id() == $this->id)
      {
        return self::CEST_MOI;
      }

      
      $this->experience += 25;
      // On indique au personnage qu'il doit recevoir des dégâts.
      // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE
      return $this->Attaque($perso);
    }


    public function recevoirDegats($type, $force)
    {
        if($type == 'Guerrier'){
            $this->degats += (5 + $force)*2;
        }else{
            $this->degats += 5;
        }
      
    
       // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
       if($this->degats >= 100)
       {
         return self::PERSONNAGE_TUE;
       }
    
       // Sinon, on se contente de dire que le personnage a bien été frappé.
       return self::PERSONNAGE_FRAPPE;
    }

  
    //Getters//
    public function type()
      {
        return $this->type;
      }
    //Setters//
    public function setType($type)
      {
          $this->type = $type;
      }
    
}   