<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Patient;
use App\Models\Village;
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
            'type' => 'required',
            'month' => 'between:1,12',
            'year' => 'required|integer',
        ]);

        $data['type'] = $request->get('type');
        $data['month'] = $request->get('month');
        $data['year'] = $request->get('year');

        $patients = Patient::getPatientsForReport($data['type'], $data['month'], $data['year']);

        $hypertension = $patients->groupBy(['village_id', 'is_hypertension', 'sex']);
        $treatment = $patients->groupBy(['village_id', 'is_routine', 'sex']);

        $villages = Village::all();

        // Untuk Tabel
        $villages->map(function ($village, $key) use ($hypertension, $treatment) {
            $village->hypertension = $hypertension[$village->id] ?? [];
            $village->treatment = $treatment[$village->id] ?? [];
        });

        $data['villages'] = $villages;

        $data['hypertensionCount'] = count($patients->groupBy('is_hypertension')[1] ?? []);
        $data['notHypertensionCount'] = count($patients->groupBy('is_hypertension')[0] ?? []);
        $data['routineTreatmentCount'] = count($patients->groupBy('is_routine')[1] ?? []);
        $data['notRoutineTreatmentCount'] = count($patients->groupBy('is_routine')[0] ?? []);

        $data['hypertensionCountMale'] = count($patients->groupBy(['is_hypertension', 'sex'])[1]['L'] ?? []);
        $data['notHypertensionCountMale'] = count($patients->groupBy(['is_hypertension', 'sex'])[0]['L'] ?? []);
        $data['routineTreatmentCountMale'] = count($patients->groupBy(['is_routine', 'sex'])[1]['L'] ?? []);
        $data['notRoutineTreatmentCountMale'] = count($patients->groupBy(['is_routine', 'sex'])[0]['L'] ?? []);
        $data['hypertensionCountFemale'] = count($patients->groupBy(['is_hypertension', 'sex'])[1]['P'] ?? []);
        $data['notHypertensionCountFemale'] = count($patients->groupBy(['is_hypertension', 'sex'])[0]['P'] ?? []);
        $data['routineTreatmentCountFemale'] = count($patients->groupBy(['is_routine', 'sex'])[1]['P'] ?? []);
        $data['notRoutineTreatmentCountFemale'] = count($patients->groupBy(['is_routine', 'sex'])[0]['P'] ?? []);

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

    public function exportReport(Request $request)
    {
        $data['type'] = $request->get('type');
        $data['month'] = $request->get('month');
        $data['year'] = $request->get('year');

        $patients = Patient::getPatientsForReport($data['type'], $data['month'], $data['year']);

        $hypertension = $patients->groupBy(['village_id', 'is_hypertension', 'sex']);
        $treatment = $patients->groupBy(['village_id', 'is_routine', 'sex']);

        $villages = Village::all();

        // Untuk Tabel
        $villages->map(function ($village, $key) use ($hypertension, $treatment) {
            $village->hypertension = $hypertension[$village->id] ?? [];
            $village->treatment = $treatment[$village->id] ?? [];
        });

        $data['villages'] = $villages;

        $data['hypertensionCount'] = count($patients->groupBy('is_hypertension')[1] ?? []);
        $data['notHypertensionCount'] = count($patients->groupBy('is_hypertension')[0] ?? []);
        $data['routineTreatmentCount'] = count($patients->groupBy('is_routine')[1] ?? []);
        $data['notRoutineTreatmentCount'] = count($patients->groupBy('is_routine')[0] ?? []);

        $data['hypertensionCountMale'] = count($patients->groupBy(['is_hypertension', 'sex'])[1]['L'] ?? []);
        $data['notHypertensionCountMale'] = count($patients->groupBy(['is_hypertension', 'sex'])[0]['L'] ?? []);
        $data['routineTreatmentCountMale'] = count($patients->groupBy(['is_routine', 'sex'])[1]['L'] ?? []);
        $data['notRoutineTreatmentCountMale'] = count($patients->groupBy(['is_routine', 'sex'])[0]['L'] ?? []);
        $data['hypertensionCountFemale'] = count($patients->groupBy(['is_hypertension', 'sex'])[1]['P'] ?? []);
        $data['notHypertensionCountFemale'] = count($patients->groupBy(['is_hypertension', 'sex'])[0]['P'] ?? []);
        $data['routineTreatmentCountFemale'] = count($patients->groupBy(['is_routine', 'sex'])[1]['P'] ?? []);
        $data['notRoutineTreatmentCountFemale'] = count($patients->groupBy(['is_routine', 'sex'])[0]['P'] ?? []);

        return Excel::download(new ReportExport($data), 'report.xlsx');
    }
}
