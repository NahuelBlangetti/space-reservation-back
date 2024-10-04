<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $fillable = ['user_id', 'space_id', 'start_time', 'end_time', 'day_of_week'];
}
