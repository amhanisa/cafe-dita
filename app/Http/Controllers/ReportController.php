<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Patient;
use App\Models\Village;
use App\Services\PatientStatusService;
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
        ]);

        $data['startDate'] = $request->get('start_date');
        $data['endDate'] = $request->get('end_date');

        $patients = Patient::getPatientsForReport($data['startDate'], $data['endDate']);

        $calculatedPatients = $this->calculatePatientsStatus($patients, $data["endDate"]);

        $hypertension = $calculatedPatients->groupBy(['village_id', 'hypertension_status', 'sex']);
        $treatment = $calculatedPatients->groupBy(['village_id', 'treatment_status', 'sex']);

        $villages = Village::all();

        // Untuk Tabel
        $villages->map(function ($village, $key) use ($hypertension, $treatment) {
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
            $patient->hypertension_status = PatientStatusService::checkHypertensionStatus($patient->consultations);
            if ($patient->hypertension_status) {
                $patient->treatment_status = PatientStatusService::checkTreatmentStatus($patient->consultations);
            } else {
                $patient->treatment_status = true;
            }
        };

        return $patients;
    }

    public function exportReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|before:tomorrow',
        ]);

        $data['startDate'] = $request->get('start_date');
        $data['endDate'] = $request->get('end_date');

        $patients = Patient::getPatientsForReport($data['startDate'], $data['endDate']);

        $calculatedPatients = $this->calculatePatientsStatus($patients, $data["endDate"]);

        $hypertension = $calculatedPatients->groupBy(['village_id', 'hypertension_status', 'sex']);
        $treatment = $calculatedPatients->groupBy(['village_id', 'treatment_status', 'sex']);

        $villages = Village::all();

        $villages->map(function ($village, $key) use ($hypertension, $treatment) {
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
