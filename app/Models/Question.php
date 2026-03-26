<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'section_id',
        'question_text_gu',
        'question_text_en',
        'type',
        'is_required',
        'order',
        'is_active',
        'meta_params'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'meta_params' => 'array'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class)->orderBy('order');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
