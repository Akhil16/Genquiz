<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function getOptionUnique(){

        return "opt" . uniqid(rand(10000000,99999999));
    }
}
