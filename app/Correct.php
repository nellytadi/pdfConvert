<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correct extends Model
{
    protected $fillable = ['question_id','correct_answer'];
}
