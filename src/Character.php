<?php

namespace App;

use PharIo\Version\AndVersionConstraintGroup;

class Character
{
    private int $charId = 1;
    private int $health = 1000;
    private int $level = 1;
    private bool $alive = true;
    
    public function hit(int $hitPoints, Character $victim) {
        if($this->charId !== $victim->charId){
            $victimLifePoints = $victim->getHealth(); 
            $hitPoints= $this->compareLevels($hitPoints,$victim);
            $victimLifePoints -= $hitPoints; 
            $victim-> setHealth($victimLifePoints);
            $victim->checkHealNotUnderZero(); 
        }
    }
    
    public function setCharId(int $id) {
        $this->charId = $id;
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
    
    public function setLevel(int $level) {
        $this->level = $level;
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

    public function heal(int $pointsOfHeal) {
        
        if($this->alive){ 
        $healedLifePoints = $this->getHealth();
        $healedLifePoints += $pointsOfHeal; 
        $this-> setHealth($healedLifePoints);
        $this-> checkHealNotOver1000();
        }
        
    }

    public function compareLevels($hitPoints, $target){
        $targetLevel = $target ->getLevel();
        $attackerLevel = $this->getLevel();
        $levelDelta = abs($attackerLevel - $targetLevel);
        if(($levelDelta >= 5)and($targetLevel > $attackerLevel)){
            $hitPoints = $hitPoints/2;
            return $hitPoints;
        }elseif (($levelDelta >= 5)and($attackerLevel > $targetLevel)) {
            $hitPoints = $hitPoints*1.5;
            return $hitPoints;
        }
        return $hitPoints;
    }
}
