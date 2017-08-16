<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public function getRouteKeyName()
    {
        return "quiz_slug";
    }

    public function getQuizUnique(){

        return "qz" . uniqid(rand(10000,99999));
    }
}
