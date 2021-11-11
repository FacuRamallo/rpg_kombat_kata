<?php

namespace App;

class Character
{
    private int $health = 1000;
    private int $level = 1;
    private bool $alive = true;
    
    public function hit(int $damaged, Character $victim) {
        $victimLifePoints = $victim->getHealth(); 
        $victimLifePoints -= $damaged; 
        $victim-> setHealth($victimLifePoints);
        $victim->checkHealNotUnderZero(); 
    }

    public function setHealth(int $lifePoints) {
        $this->health = $lifePoints;
    }
    
    public function getHealth()
    {
       return $this->health;
    }

   public function getLevel()
   {
       return $this->level;
    }

    public function die() {
        $this->health = 0;
        $this->alive = false;
    }

   public function isAlive()
   {
       return $this->alive;
    }

    public function checkHealNotUnderZero() {
        if(0 >= $this->getHealth()) {
        $this->die();
        }
    }
    public function checkHealNotOver1000() {
        if($this->getHealth()>1000) {
        $this->setHealth(1000);
        }
    }

    public function heal(int $pointsOfHeal, Character $healedChar) {
        $healedLifePoints = $healedChar->getHealth();
        if($healedChar->alive){ 
        $healedLifePoints += $pointsOfHeal; 
        $healedChar-> setHealth($healedLifePoints);
        $healedChar-> checkHealNotOver1000();
        }
        
        
    }
}
