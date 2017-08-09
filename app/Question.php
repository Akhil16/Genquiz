<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Option;

class Question extends Model
{
    public function getQuestionUnique(){

        return "ques" . uniqid(rand(10000,99999));
    }
}
