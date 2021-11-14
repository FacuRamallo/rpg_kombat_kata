<?php
namespace App;

use App\Character;


class MeleChar extends Character
{
    public function __construct()
    {
        $this -> charId = rand();
        
        $this -> maxRange = 2;
    }
}