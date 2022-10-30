<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Village;
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

        $calculatedPatients = $this->calculatePatientsStatus($patients);

        $villages = Village::all();
        $name =  $villages->pluck('name');


        $data['hypertension'] = $calculatedPatients->groupBy(['village', 'hypertension_status', 'sex']);
        $data['treatment'] = $calculatedPatients->groupBy(['village', 'treatment_status', 'sex']);
        // $merge = $villages->merge($data['hypertension']);
        // $merge->all();
        dd($name, $data['hypertension']);
        // dd($calculatedPatients->where('village', '=', 'Ngentrong')->groupBy(['sex', 'hypertension_status']));
        return view('report.index', $data);
    }

    public function calculatePatientsStatus($patients)
    {
        // TODO susah ni ga kepikiran ngitungnya gimana haha
        foreach ($patients as $patient) {
            $patient->hypertension_status = $this->calculateHypertensionStatus($patient->consultation);
            $patient->treatment_status = $this->calculateTreatmentStatus($patient->consultation);
        };

        return $patients;
        // dd($patients->groupBy(['village', 'sex']), $patients[0]);
    }

    public function calculateHypertensionStatus($consultations)
    {
        $averageSystole = $consultations->avg('systole');
        $averageDiastole = $consultations->avg('diastole');

        if ($averageSystole >= 140 || $averageDiastole >= 90) {
            $hypertensionStatus = true;
        } else {
            $hypertensionStatus = false;
        }

        return $hypertensionStatus;
    }

    public function calculateTreatmentStatus($last12Months)
    {
        if (count($last12Months) < 1) {
            return false;
        }

        $firstDate = $last12Months[0]->date;
        $year = $this->getYear($firstDate);
        $month = $this->getMonth($firstDate);

        $iteration = 0;

        $data = [];
        $lenght = $last12Months->count();

        // Ubah Tanggal Menjadi Bulan Saja Menghilangkan Tahun
        // Agar Bisa Dikalkulasi
        for ($i = 0; $i < $lenght; $i++) {
            $monthData = $this->getMonth($last12Months[$i]->date);
            $yearData = $this->getYear($last12Months[$i]->date);

            if ($yearData == $year) {
                $data[$i] = $monthData;
            } else {
                $data[$i] = $monthData + 12;
            }
        }

        // Cek Array Apakah Ada 3 Angka Yang Berurutan
        for ($i = 0; $i < count($data) - 1; $i++) {
            if ($data[$i] + 1 == $data[$i + 1]) {
                $iteration += 1;
            } else if ($data[$i] + 1 < $data[$i + 1]) {
                $iteration = 0;
            }

            if ($iteration == 2) {
                return true;
            }
        }

        return false;
    }

    public function getMonth($string)
    {
        return (int)substr($string, 5, 2);
    }

    public function getYear($string)
    {
        return (int)substr($string, 0, 4);
    }
}
