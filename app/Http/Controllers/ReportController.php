<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Patient;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // TODO: Set batas-batas yg memungkinkan dari 4 variabel ini
        $startDate = $request->get('start_date') ?? '2010-01-01';
        $endDate = $request->get('end_date') ?? Carbon::now()->format('Y-m-d');
        $minAge = $request->get('min_age') ?? 0;
        $maxAge = $request->get('max_age') ?? 100;

        $patients = Patient::getPatientsForReport($startDate, $endDate, $minAge, $maxAge);

        $calculatedPatients = $this->calculatePatientsStatus($patients, $endDate);

        $villages = Village::all();

        $hypertension = $calculatedPatients->groupBy(['village_id', 'hypertension_status', 'sex']);
        $treatment = $calculatedPatients->groupBy(['village_id', 'treatment_status', 'sex']);

        $villages->map(function ($village, $key) use ($hypertension, $treatment) {
            $village->hypertension = $hypertension[$village->id];
            $village->treatment = $treatment[$village->id];
        });

        $data['villages'] = $villages;

        return view('report.index', $data);
    }

    public function calculatePatientsStatus($patients, $endDate)
    {
        foreach ($patients as $patient) {
            $last3MonthsConsultations = $patient->consultations->whereBetween('date', [Carbon::parse($endDate)->subMonths(3), $endDate]);

            $patient->hypertension_status = $this->checkHypertensionStatus($last3MonthsConsultations);
            $patient->treatment_status = $this->checkTreatmentStatus($patient->consultations);
        };

        return $patients;
    }

    // Cara menentukan status hipertensi
    // Cek data konsultasi 3 bulan terakhir
    // Jika selama 3 bulan nilainya dibawah batas 140/90
    // Maka ditetapkan hipertensi terkendali (false)
    // Jika nilai diatas batas 140/90
    // Maka ditetapkan hipertensi tidak terkendali (true)
    function checkHypertensionStatus($last3MonthsConsultations)
    {
        if ($last3MonthsConsultations->count() < 1) {
            return true;
        }

        $groupedConsultations = $last3MonthsConsultations->groupBy(function ($item) {
            return Carbon::createFromFormat('Y-m-d', $item->date)->format('Y-m');
        });

        if ($groupedConsultations->count() < 3) {
            return true;
        }

        foreach ($last3MonthsConsultations as $consultation) {
            if ($consultation->systole >= 140 || $consultation->diastole >= 90) {
                return true;
            }
        }

        return false;
    }

    // Cara menentukan status berobat
    // Cek data konsultasi 12 bulan terakhir
    // Jika selama 12 bulan ada 3 bulan berobat berturut
    // Maka ditetapkan berobat teratur (true)
    // Jika tidak ditetapkan berobat tidak teratur (false)
    function checkTreatmentStatus($last12MonthsConsultations)
    {
        if ($last12MonthsConsultations->count() < 1) {
            return false;
        }

        $firstDate = $last12MonthsConsultations[0]->date;
        $firstYear = $this->getYear($firstDate);

        $data = [];
        $lenght = $last12MonthsConsultations->count();

        // Ubah Tanggal Menjadi Bulan Saja Menghilangkan Tahun
        // Agar Bisa Dikalkulasi
        // 2022-11 -> 11
        // 2022-12 -> 12
        // 2023-01 -> 13
        // 2024-02 -> 14
        for ($i = 0; $i < $lenght; $i++) {
            $consultationMonth = $this->getMonth($last12MonthsConsultations[$i]->date);
            $consultationYear = $this->getYear($last12MonthsConsultations[$i]->date);

            if ($consultationYear == $firstYear) {
                $data[$i] = $consultationMonth;
            } else {
                $data[$i] = $consultationMonth + 12;
            }
        }

        $iteration = 0;

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

    function getMonth($string)
    {
        return (int)substr($string, 5, 2);
    }

    function getYear($string)
    {
        return (int)substr($string, 0, 4);
    }

    public function exportReport(Request $request)
    {
        // TODO: Ubah jadi method post
        $startDate = $request->get('start_date') ?? '2010-01-01';
        $endDate = $request->get('end_date') ?? Carbon::now()->format('Y-m-d');
        $minAge = $request->get('min_age') ?? 0;
        $maxAge = $request->get('max_age') ?? 100;

        $patients = Patient::getPatientsForReport($startDate, $endDate, $minAge, $maxAge);

        $calculatedPatients = $this->calculatePatientsStatus($patients, $endDate);

        $villages = Village::all();

        $hypertension = $calculatedPatients->groupBy(['village_id', 'hypertension_status', 'sex']);
        $treatment = $calculatedPatients->groupBy(['village_id', 'treatment_status', 'sex']);

        $villages->map(function ($village, $key) use ($hypertension, $treatment) {
            $village->hypertension = $hypertension[$village->id];
            $village->treatment = $treatment[$village->id];
        });

        return Excel::download(new ReportExport($villages), 'report.xlsx');
    }
}
