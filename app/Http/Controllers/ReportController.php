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
    public function showReportPage(Request $request)
    {
        if (!$request->query()) {
            return view('report.filter');
        }

        $request->validate([
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|before:tomorrow',
            'min_age' => 'required|numeric|integer|min:0|',
            'max_age' => 'required|numeric|integer|gte:min_age'
        ]);

        $data['startDate'] = $request->get('start_date');
        $data['endDate'] = $request->get('end_date');
        $data['minAge'] = $request->get('min_age');
        $data['maxAge'] = $request->get('max_age');

        $patients = Patient::getPatientsForReport($data['startDate'], $data['endDate'], $data['minAge'], $data['maxAge']);

        $calculatedPatients = $this->calculatePatientsStatus($patients, $data["endDate"]);

        $hypertension = $calculatedPatients->groupBy(['village_id', 'hypertension_status', 'sex']);
        $treatment = $calculatedPatients->groupBy(['village_id', 'treatment_status', 'sex']);

        $villages = Village::all();

        // Untuk Tabel
        $villages->map(function ($village, $key) use ($hypertension, $treatment) {
            // TODO CHECK THIS SHIT
            $village->hypertension = $hypertension[$village->id] ?? [];
            $village->treatment = $treatment[$village->id] ?? [];
        });

        $data['villages'] = $villages;

        $data['hypertensionCount'] = count($calculatedPatients->groupBy('hypertension_status')[1] ?? []);
        $data['notHypertensionCount'] = count($calculatedPatients->groupBy('hypertension_status')[0] ?? []);
        $data['routineTreatmentCount'] = count($calculatedPatients->groupBy('treatment_status')[1] ?? []);
        $data['notRoutineTreatmentCount'] = count($calculatedPatients->groupBy('treatment_status')[0] ?? []);

        $data['hypertensionCountMale'] = count($calculatedPatients->groupBy(['hypertension_status', 'sex'])[1]['L'] ?? []);
        $data['notHypertensionCountMale'] = count($calculatedPatients->groupBy(['hypertension_status', 'sex'])[0]['L'] ?? []);
        $data['routineTreatmentCountMale'] = count($calculatedPatients->groupBy(['treatment_status', 'sex'])[1]['L'] ?? []);
        $data['notRoutineTreatmentCountMale'] = count($calculatedPatients->groupBy(['treatment_status', 'sex'])[0]['L'] ?? []);
        $data['hypertensionCountFemale'] = count($calculatedPatients->groupBy(['hypertension_status', 'sex'])[1]['P'] ?? []);
        $data['notHypertensionCountFemale'] = count($calculatedPatients->groupBy(['hypertension_status', 'sex'])[0]['P'] ?? []);
        $data['routineTreatmentCountFemale'] = count($calculatedPatients->groupBy(['treatment_status', 'sex'])[1]['P'] ?? []);
        $data['notRoutineTreatmentCountFemale'] = count($calculatedPatients->groupBy(['treatment_status', 'sex'])[0]['P'] ?? []);

        // Untuk Bar Chart
        $data['hypertensionCountPerVillage'] = [];
        $data['notHypertensionCountPerVillage'] = [];
        $data['routineTreatmentCountPerVillage'] = [];
        $data['notRoutineTreatmentCountPerVillage'] = [];

        foreach (range(1, 12) as $index) {
            $data['hypertensionCountPerVillage'][] = count($hypertension[$index][1]['L'] ?? []) + count($hypertension[$index][1]['P'] ?? []);
            $data['notHypertensionCountPerVillage'][] = count($hypertension[$index][0]['L'] ?? []) + count($hypertension[$index][0]['P'] ?? []);
            $data['routineTreatmentCountPerVillage'][] = count($treatment[$index][1]['L'] ?? []) + count($treatment[$index][1]['P'] ?? []);
            $data['notRoutineTreatmentCountPerVillage'][] = count($treatment[$index][0]['L'] ?? []) + count($treatment[$index][0]['P'] ?? []);
        }

        return view('report.index', $data);
    }

    private function calculatePatientsStatus($patients, $endDate)
    {
        foreach ($patients as $patient) {
            $last3MonthsConsultations = $patient->consultations->whereBetween('date', [Carbon::now()->endOfMonth()->subMonths(3)->format('Y-m-d'), now()]);

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
    private function checkHypertensionStatus($last3MonthsConsultations)
    {
        if ($last3MonthsConsultations->count() < 3) {
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
    private function checkTreatmentStatus($last12MonthsConsultations)
    {
        if ($last12MonthsConsultations->count() < 3) {
            return false;
        }

        $groupedConsultations = $last12MonthsConsultations->groupBy(function ($item) {
            return Carbon::createFromFormat('Y-m-d', $item->date)->format('Y-m');
        });

        $months = $groupedConsultations->keys();

        $counter = 1;

        for ($i = 0; $i < count($months) - 1; $i++) {
            $firstMonth = Carbon::parse($months[$i], 'UTC');
            $secondMonth = Carbon::parse($months[$i + 1], 'UTC');

            if ($firstMonth->diffInMonths($secondMonth) == 1) {
                $counter++;
            } else {
                $counter = 1;
            }

            if ($counter == 3) {
                return true;
            }
        }

        return false;
    }

    public function exportReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|before:tomorrow',
            'min_age' => 'required|numeric|integer|min:0|',
            'max_age' => 'required|numeric|integer|gte:min_age'
        ]);

        $data['startDate'] = $request->get('start_date');
        $data['endDate'] = $request->get('end_date');
        $data['minAge'] = $request->get('min_age');
        $data['maxAge'] = $request->get('max_age');

        $patients = Patient::getPatientsForReport($data['startDate'], $data['endDate'], $data['minAge'], $data['maxAge']);

        $calculatedPatients = $this->calculatePatientsStatus($patients, $data["endDate"]);

        $hypertension = $calculatedPatients->groupBy(['village_id', 'hypertension_status', 'sex']);
        $treatment = $calculatedPatients->groupBy(['village_id', 'treatment_status', 'sex']);

        $villages = Village::all();

        // Untuk Tabel
        $villages->map(function ($village, $key) use ($hypertension, $treatment) {
            // TODO CHECK THIS SHIT
            $village->hypertension = $hypertension[$village->id] ?? [];
            $village->treatment = $treatment[$village->id] ?? [];
        });

        $data['villages'] = $villages;

        $data['hypertensionCount'] = count($calculatedPatients->groupBy('hypertension_status')[1] ?? []);
        $data['notHypertensionCount'] = count($calculatedPatients->groupBy('hypertension_status')[0] ?? []);
        $data['routineTreatmentCount'] = count($calculatedPatients->groupBy('treatment_status')[1] ?? []);
        $data['notRoutineTreatmentCount'] = count($calculatedPatients->groupBy('treatment_status')[0] ?? []);

        $data['hypertensionCountMale'] = count($calculatedPatients->groupBy(['hypertension_status', 'sex'])[1]['L'] ?? []);
        $data['notHypertensionCountMale'] = count($calculatedPatients->groupBy(['hypertension_status', 'sex'])[0]['L'] ?? []);
        $data['routineTreatmentCountMale'] = count($calculatedPatients->groupBy(['treatment_status', 'sex'])[1]['L'] ?? []);
        $data['notRoutineTreatmentCountMale'] = count($calculatedPatients->groupBy(['treatment_status', 'sex'])[0]['L'] ?? []);
        $data['hypertensionCountFemale'] = count($calculatedPatients->groupBy(['hypertension_status', 'sex'])[1]['P'] ?? []);
        $data['notHypertensionCountFemale'] = count($calculatedPatients->groupBy(['hypertension_status', 'sex'])[0]['P'] ?? []);
        $data['routineTreatmentCountFemale'] = count($calculatedPatients->groupBy(['treatment_status', 'sex'])[1]['P'] ?? []);
        $data['notRoutineTreatmentCountFemale'] = count($calculatedPatients->groupBy(['treatment_status', 'sex'])[0]['P'] ?? []);

        return Excel::download(new ReportExport($data), 'report.xlsx');
    }
}
