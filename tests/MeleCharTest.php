<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

use App\MeleChar;

class MeleCharTest extends TestCase 
{
    public function test_Melee_fighters_have_a_range_of_2_meters() {
        $meleChar1 = new MeleChar;
        $meleChar2 = new MeleChar;

        
        $this -> assertEquals(2, $meleChar1->getmaxRange());
        $this -> assertEquals(2, $meleChar2->getmaxRange());
    }

}