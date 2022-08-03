<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'description' => '',
        'completed' => false,
        'tags' => '[]'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
