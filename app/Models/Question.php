<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'section_name',
        'section_title_gu',
        'section_title_en',
        'question_text_gu',
        'question_text_en',
        'type',
        'is_required',
        'order',
        'is_active',
    ];

    public function options()
    {
        return $this->hasMany(Option::class)->orderBy('order');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
