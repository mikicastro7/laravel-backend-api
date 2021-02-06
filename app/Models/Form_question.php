<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form_question extends Model
{
    protected $fillable = [
        'title', 'description', 'form_elements', 'user_id', 'form_key'
    ];
}

