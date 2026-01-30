<?php

namespace App\Repositories;

class ProviderTest
{
    public $count = 4;
    public function num(int $a){
        $this->count += $a;
        dump( $this->count);
    }
}
