<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\Patient;
use App\Models\PatientHabit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function showEditPage(Request $request)
    {
        $patientId = $request->query('patient');
        $year = $request->query('year');
        $month = $request->query('month');

        $data['patient'] = Patient::find($patientId);
        $data['habits'] =  Habit::with(['patientHabit' => function ($query) use ($patientId, $year, $month) {
            $query->where('patient_id', $patientId)->where('year', $year)->where('month', $month);
        }])->get();
        $data['year'] = $year;
        $data['month'] = $month;
        $data['monthName'] = date("F", mktime(0, 0, 0, $month, 10));;

        return view('habit.edit', $data);
    }

    public function store(Request $request)
    {
        $habits = Habit::all();

        foreach ($habits as $habit) {
            $patientHabit = PatientHabit::updateOrCreate(
                [
                    'patient_id' => $request->patient_id,
                    'habit_id' => $habit->id,
                    'year' => $request->year,
                    'month' => $request->month,
                ],
                [
                    'week1' => $request->{"habit-$habit->id-week-1"},
                    'week2' => $request->{"habit-$habit->id-week-2"},
                    'week3' => $request->{"habit-$habit->id-week-3"},
                    'week4' => $request->{"habit-$habit->id-week-4"},
                    'note' => $request->{"note-$habit->id"}
                ]
            );
        }

        dd($request->patient_id, $request->date, $request);
    }
}
