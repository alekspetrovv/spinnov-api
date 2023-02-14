<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_type',
    ];


    public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function sensors()
    {
        return $this->hasMany(Sensor::class, 'device_id', 'id');
    }

}
