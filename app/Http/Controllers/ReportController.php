<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // TODO: Set batas-batas yg memungkinkan dari 4 variabel ini
        $startDate = $request->query('start_date') ?? '2010-01-01';
        $endDate = $request->query('end_date') ?? Carbon::now()->format('Y-m-d');
        $minAge = $request->query('min_age') ?? 0;
        $maxAge = $request->query('max_age') ?? 100;

        $patients = Patient::getPatientsForReport($startDate, $endDate, $minAge, $maxAge);

        $this->calculateHipertension($patients);

        return view('report.index');
    }

    public function calculateHipertension($patients)
    {
        // TODO susah ni ga kepikiran ngitungnya gimana haha
    }
}
