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

        $attaker = new MeleChar();
        $damaged = new MeleChar();
        

        $attaker->hit(100, $damaged,0);

        $this-> assertEquals(900, $damaged->getHealth());
    }

    public function test_damage_exceeds_Health_it_becomes_0_and_character_dies() {
        $damaged = new Character();
        $attaker = new Character();
        $damaged ->setCharId(2);
        $attaker->hit(1100,$damaged,0);
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
        
        
        $attakerChar ->hit(100, $attakerChar,0);

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

        $attakerChar ->hit(100,$targetChar,0);

        $this->assertEquals(950,$targetChar->getHealth());

    }
    public function test_If_the_target_is_5_or_more_Levels_below_the_attacker_Damage_is_increased_by_50percent(){
        $targetChar = new Character();
        $attakerChar = new Character();
        $targetChar ->setCharId(2);
        $attakerChar ->setLevel(10);

        $attakerChar ->hit(100,$targetChar,0);

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

    public function test_Characters_may_belong_to_one_or_more_Factions(){
        $Character1 = new MeleChar;
        $Character2 = new RangedChar;

        $gameFactions=array(
            0 => 'faction_a',
            1 => 'faction_b',
            2 => 'faction_c',
            3 => 'faction_d'
        );

        $Character1 -> joinFaction('faction_c',$gameFactions);
        $Character2 -> joinFaction('faction_b',$gameFactions);
        $Character2 -> joinFaction('faction_a',$gameFactions);

        $Character1_factions = $Character1->getFactions();
        $Character2_factions = $Character2->getFactions();
        
        $this-> assertEquals(1, $Character1_factions[2]);
        $this-> assertEquals(1, $Character2_factions[1]);
        $this-> assertEquals(1, $Character2_factions[0]);

    }

    public function test_Newly_created_Characters_belong_to_no_Faction(){
        $Character1 = new MeleChar;

        $numOfFactionsCharBelongsTo = $Character1->factionsCharBelongsTo();

        $this-> assertEquals(0,$numOfFactionsCharBelongsTo);
    }

    public function test_A_Character_may_Join_or_Leave_one_or_more_Factions(){
        $Character1 = new MeleChar;
       

        $gameFactions=array(
            0 => 'faction_a',
            1 => 'faction_b',
            2 => 'faction_c',
            3 => 'faction_d'
        );

        $Character1 -> joinFaction('faction_a',$gameFactions);
        $Character1 -> joinFaction('faction_c',$gameFactions);
        $Character1 -> joinFaction('faction_d',$gameFactions);
       

        $Character1_factions = $Character1->getFactions();
       
        $this-> assertEquals(1, $Character1_factions[0]);
        $this-> assertEquals(1, $Character1_factions[2]);
        $this-> assertEquals(1, $Character1_factions[3]);

        $Character1 -> leaveFaction('faction_a',$gameFactions);
        $Character1 -> leaveFaction('faction_c',$gameFactions);
        
        $Character1_factions = $Character1->getFactions();

        $this-> assertEquals(0, $Character1_factions[0]);
        $this-> assertEquals(0, $Character1_factions[2]);
        $this-> assertEquals(1, $Character1_factions[3]);
    }

    public function test_Players_belonging_to_the_same_Faction_are_considered_Allies() {
        $Character1 = new MeleChar;
        $Character2 = new RangedChar;

        $gameFactions=array(
            0 => 'faction_a',
            1 => 'faction_b',
            2 => 'faction_c',
            3 => 'faction_d'
        );

        $Character1 -> joinFaction('faction_a',$gameFactions);
        $Character2 -> joinFaction('faction_a',$gameFactions);

        $areCharactersAllies = $Character1 -> checkCharsAreAllies($Character2);

        $this-> assertTrue($areCharactersAllies);
    }

    public function test_Allies_cannot_Deal_Damage_to_one_another() {
        $attackerChar= new MeleChar;
        $targetChar= new RangedChar;

        $gameFactions=array(
            0 => 'faction_a',
            1 => 'faction_b',
            2 => 'faction_c',
            3 => 'faction_d'
        );

        $attackerChar -> joinFaction('faction_a',$gameFactions);
        $targetChar -> joinFaction('faction_a',$gameFactions);

        $attackerChar -> hit(100,$targetChar,0);

        $this -> assertEquals(1000,$targetChar->getHealth());
    }

    public function test_Allies_can_Heal_one_another(){
        $healerChar= new MeleChar;
        $damagedChar= new RangedChar;

        $gameFactions=array(
            0 => 'faction_a',
            1 => 'faction_b',
            2 => 'faction_c',
            3 => 'faction_d'
        );

        $damagedChar -> setHealth(600);

        $healerChar -> joinFaction('faction_a',$gameFactions);
        $damagedChar -> joinFaction('faction_a',$gameFactions);

        $healerChar -> heal(200,$damagedChar);

        $this -> assertEquals(800,$damagedChar->getHealth());
    }
   
    
}
