<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'answers',
        'traits',
    ];

    protected $casts = [
        'answers' => 'array',
        'traits' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
