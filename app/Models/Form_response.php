<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form_response extends Model
{
    protected $fillable = [
        'title', 'description', 'form_elements', 'form_question_id', 'user_id'
    ];
}
