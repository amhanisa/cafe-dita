<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function showEditPage($patientId)
    {
        $data['patient'] = Patient::find($patientId);

        return view('habit.edit', $data);
    }
}
