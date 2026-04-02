<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_identifier',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
