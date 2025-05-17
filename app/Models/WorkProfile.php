<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkProfile extends Model
{
    /** @use HasFactory<\Database\Factories\WorkProfileFactory> */
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'skills' => 'array'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
