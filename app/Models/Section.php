<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['title_gu', 'title_en', 'order', 'is_active'];

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }
}
