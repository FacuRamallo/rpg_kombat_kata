<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Character;

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

        $attaker->hit(100, $damaged);

        $this-> assertEquals(900, $damaged->getHealth());
    }

    public function test_damage_exceeds_Health_it_becomes_0_and_character_dies() {
        $damaged = new Character();
        $attaker = new Character();
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

}
