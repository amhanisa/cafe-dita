<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\Patient;
use App\Models\PatientHabit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientHabitController extends Controller
{
    public function showEditPatientHabitPage(Request $request)
    {
        $patientId = $request->query('patient');
        $year = $request->query('year');
        $month = $request->query('month');

        $data['patient'] = Patient::find($patientId);
        $data['habits'] =  (new Habit)->getPatientHabitsByMonth($patientId, $year, $month);
        $data['year'] = $year;
        $data['month'] = $month;
        $data['monthName'] = Carbon::create($year, $month)->translatedFormat('F Y');

        return view('habit.edit', $data);
    }

    public function storePatientHabit(Request $request)
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

        return redirect('patient/' . $request->patient_id . '?year=' . $request->year)
            ->with('toast_success', 'Data kebiasaan pasien berhasil disimpan');
    }
}
