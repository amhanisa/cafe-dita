<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    public $timestamps = false;

    public function patientHabits()
    {
        return $this->hasMany(PatientHabit::class);
    }

    public static function getPatientHabits($patientId, $year)
    {
        return Habit::with(['patientHabits' => function ($query) use ($patientId, $year) {
            $query->where('patient_id', $patientId)
                ->where('year', $year)
                ->orderBy('month', 'asc');
        }])->get();
    }

    public static function getPatientHabitsByMonth($patientId, $year, $month)
    {
        return Habit::with(['patientHabits' => function ($query) use ($patientId, $year, $month) {
            $query->where('patient_id', $patientId)->where('year', $year)->where('month', $month);
        }])->get();
    }
}
