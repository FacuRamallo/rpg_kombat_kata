<?php

namespace App;

use App\Character;

class RangedChar extends Character
{
    public function __construct()
    {
        $this -> charId = rand();
        
        $this -> maxRange = 20;
    }
}
