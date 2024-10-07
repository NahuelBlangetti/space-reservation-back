<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $table = 'spaces';
    protected $fillable = ['name', 'description', 'capacity', 'type', 'is_available','photo'];

    public function reservations()
    {
        return $this->hasMany(Reservations::class);
    }
}
