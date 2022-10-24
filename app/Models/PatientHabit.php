<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientHabit extends Model
{
    protected $fillable = ['patient_id', 'habit_id', 'year', 'month', 'week1', 'week2', 'week3', 'week4', 'note'];
}
