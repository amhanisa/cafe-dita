<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    protected $table = 'habits';
    public $timestamps = false;

    public function patientHabits()
    {
        return $this->hasMany(PatientHabit::class);
    }
}
