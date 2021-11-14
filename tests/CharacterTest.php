<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Character;
use App\MeleChar;
use App\RangedChar;

class CharacterTest extends TestCase
{
    public function test_Health_starting_at_1() 
    {
        $fighter = new Character();
        $result = $fighter->getHealth();
        $this->assertEquals(1000, $result);
        
        
    }
    public function test_Level_starting_at_1() 
    {
        $fighter = new Character();
        $result = $fighter->getLevel();
        $this->assertEquals(1, $result);
    }

    public function test_starting_alive() 
    {
        $fighter = new Character();
       $result = $fighter->isAlive();
       $this->assertTrue($result);
      
    }
       
    public function test_character_can_damage_and_substract_from_health() {

        $attaker = new Character();
        $damaged = new Character();
        $damaged ->setCharId();

        $attaker->hit(100, $damaged);

        $this-> assertEquals(900, $damaged->getHealth());
    }

    public function test_damage_exceeds_Health_it_becomes_0_and_character_dies() {
        $damaged = new Character();
        $attaker = new Character();
        $damaged ->setCharId(2);
        $attaker->hit(1100,$damaged);
        $this -> assertEquals(0, $damaged->getHealth());
        $this -> assertFalse($damaged->isAlive());
    }

    public function test_Dead_characters_cannot_be_healed(){
        $deadChar = new Character();
        $deadChar->die();
        $healerChar = new Character();
        
        $healerChar->heal(200,$deadChar);
        
        $this -> assertFalse($deadChar -> isAlive());
    }

    public function test_Healing_cannot_raise_health_above_1000(){
        $damagedChar = new Character();
        $healerChar = new Character();
        $damagedChar->setHealth(900);

        $healerChar->heal(200,$damagedChar);

        $this -> assertLessThanOrEqual(1000,$damagedChar->getHealth());
    }

    public function test_A_Character_cannot_Deal_Damage_to_itself(){
        
        $attakerChar = new Character();
        
        
        $attakerChar ->hit(100, $attakerChar);

        $this -> assertEquals(1000, $attakerChar->getHealth());

    }

    public function test_A_Character_can_only_Heal_itself(){
        $healerChar = new Character();
        $healerChar->setHealth(500);

        $healerChar->heal(100);

        $this-> assertEquals(600,$healerChar->getHealth());
    }

    public function test_If_the_target_is_5_or_more_Levels_above_the_attacker_Damage_is_reduced_by_50percent(){
        $targetChar = new Character();
        $attakerChar = new Character();
        $targetChar ->setCharId(2);
        $targetChar ->setLevel(10);

        $attakerChar ->hit(100,$targetChar);

        $this->assertEquals(950,$targetChar->getHealth());

    }
    public function test_If_the_target_is_5_or_more_Levels_below_the_attacker_Damage_is_increased_by_50percent(){
        $targetChar = new Character();
        $attakerChar = new Character();
        $targetChar ->setCharId(2);
        $attakerChar ->setLevel(10);

        $attakerChar ->hit(100,$targetChar);

        $this->assertEquals(850,$targetChar->getHealth());

    }

    public function test_Characters_have_an_attack_Max_Range(){
        $character = new Character;

        $characterMaxRange = $character -> getmaxRange();

        $this -> assertEquals(0,$characterMaxRange);
    }

    public function test_Characters_must_be_in_range_to_deal_damage_to_a_target(){
        $attakerChar = new RangedChar;
        $targetChar = new MeleChar;
        
        $distanceToTarget = 18;
        $attakerChar->hit(100,$targetChar,$distanceToTarget);

        $this->assertEquals(900,$targetChar->getHealth());

    }

   
    
}
