<?php

namespace App;

use phpDocumentor\Reflection\Types\Callable_;

class Character
{
    protected int $charId=0;
    protected int $health = 1000;
    protected int $level = 1;
    protected bool $alive = true;
    protected int $maxRange=0;
    protected array $factions=array(0=>0,1=>0,2=>0,3=>0);
    
    
    public function hit(int $hitPoints, Character $target,$distanceToTarget) {
        if($this->checkCharsAreAllies($target)){
            return;
        }
        if(($this->getCharId() !== $target->getCharId())&&($this->isTargetInRange($distanceToTarget))){
            $targetLifePoints = $target->getHealth(); 
            $hitPoints= $this->compareLevels($hitPoints,$target);
            $targetLifePoints -= $hitPoints; 
            $target-> setHealth($targetLifePoints);
            $target->checkHealNotUnderZero(); 
        }
    }
    
    public function heal(int $pointsOfHeal,$damaged=null) {
        if ($damaged==null){
            if($this->alive){ 
                $healedLifePoints = $this->getHealth();
                $healedLifePoints += $pointsOfHeal; 
                $this-> setHealth($healedLifePoints);
                $this-> checkHealNotOver1000();
                }
            return;
        }

        if($this->checkCharsAreAllies($damaged)){
            if($damaged->alive){ 
                $healedLifePoints = $damaged->getHealth();
                $healedLifePoints += $pointsOfHeal; 
                $damaged-> setHealth($healedLifePoints);
                $damaged-> checkHealNotOver1000();
                }
        }
        
    }
    
    public function setHealth(int $lifePoints) {
        $this->health = $lifePoints;
    }
    public function setCharId() {
        $this->charId = rand();
    }

    
    public function setLevel(int $level) {
        $this->level = $level;
    }

    public function joinFaction($faction,$gameFactions){
        $factionIndex = array_search($faction,$gameFactions);
        $this-> factions[$factionIndex] = 1;
    }

    public function leaveFaction($faction,$gameFactions){
        $factionIndex = array_search($faction,$gameFactions);
        $this-> factions[$factionIndex] = 0;
    }

    public function getHealth()
    {
       return $this->health;
    }

    public function getLevel()
    {
       return $this->level;
    }

    public function getmaxRange(){
        return $this -> maxRange;
    }

    public function getFactions(){
        return $this->factions;
    }

    public function getCharId(){
        return $this->charId;
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


    public function compareLevels($hitPoints, $target){
        $targetLevel = $target ->getLevel();
        $attackerLevel = $this->getLevel();
        $levelDelta = abs($attackerLevel - $targetLevel);
        if(($levelDelta >= 5)and($targetLevel > $attackerLevel)){
            $hitPoints = $hitPoints/2;
            return $hitPoints;
        }elseif (($levelDelta >= 5)and($targetLevel < $attackerLevel)) {
            $hitPoints = $hitPoints*1.5;
            return $hitPoints;
        }
        return $hitPoints;
    }

    public function isTargetInRange(int $distanceToTarget){
        $attackerRange = $this-> getmaxRange();
        if ($distanceToTarget>$attackerRange){
            return false;
        }
        return true;
    }
    
    public function factionsCharBelongsTo(){
        
        $numOfFactions = array_reduce
        (
            $this->factions,
            function($carry,$item){
                $carry += $item;
                return $carry;
            }
        );
        return $numOfFactions;
    }

    public function checkCharsAreAllies(Character $characterX) {
        $intersectArray = array_diff_assoc($this->getFactions(),$characterX->getFactions());
        if (count($intersectArray)==0 && $this->factionsCharBelongsTo()!=0){
            return true;
        }
        return false;
    }
    

}
