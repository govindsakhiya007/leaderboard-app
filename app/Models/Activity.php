<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'points', 'activity_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
