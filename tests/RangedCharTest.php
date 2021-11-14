<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Character;
use App\RangedChar;

class RangedCharTest extends TestCase 
{
    public function test_Ranged_fighters_have_a_range_of_20_meters() {
        $rangedChar1 = new RangedChar;
        $rangedChar2 = new RangedChar;

        
        $this -> assertEquals(20, $rangedChar1->getmaxRange());
        $this -> assertEquals(20, $rangedChar2->getmaxRange());
    }

}