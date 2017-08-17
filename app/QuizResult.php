<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $table = "quiz_results";

    public function getResultUnique(){

        return "res" . uniqid(rand(100000,999999)) . rand(1000,9999);
    }
}
