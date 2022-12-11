<?php

namespace App\Http\Controllers;

use App\DataTables\PatientsDataTable;
use App\Models\Consultation;
use App\Models\Habit;
use App\Models\Patient;
use App\Models\PatientHabit;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PatientController extends Controller
{
    public function showListPatientPage()
    {
        return view('patient.index');
    }

    public function showAddPatientPage()
    {
        $data['villages'] = Village::all();
        return view('patient.add', $data);
    }

    public function showDetailPatientPage($id)
    {
        $data['patient'] = Patient::getPatientWithVillage($id);

        $data['consultations'] = Consultation::getPatientConsultations($id);

        $last12MonthsConsultations = Consultation::getPatientConsultations($id, 'asc', 12);

        $data['hypertensionStatus'] = $this->checkHypertensionStatus($last12MonthsConsultations);
        if ($data['hypertensionStatus']) {
            $data['treatmentStatus'] = $this->checkTreatmentStatus($last12MonthsConsultations);
        } else {
            $data['treatmentStatus'] = true;
        }

        $data['year'] = request('year') ?? Carbon::now()->year;

        $data['patientHabits'] = Habit::getPatientHabits($id, $data['year']);

        return view('patient.show', $data);
    }

    public function getAjaxTensionHistory(Request $request)
    {
        $consultations = Consultation::getPatientConsultations($request->patientId, 'asc');

        $systole = [];
        $diastole = [];
        $date = [];

        foreach ($consultations as $consultation) {
            array_push($systole, $consultation->systole);
            array_push($diastole, $consultation->diastole);
            array_push($date, $consultation->date);
        }

        $data = ['systole' => $systole, 'diastole' => $diastole, 'date' => $date];

        return json_encode($data);
    }

    private function checkHypertensionStatus($last12MonthsConsultations)
    {
        if ($last12MonthsConsultations->count() < 3) {
            return true;
        }

        $aboveThreshold = $last12MonthsConsultations->reverse()->search(function ($consultation) {
            return $consultation->systole >= 140 || $consultation->diastole >= 90;
        });

        if ($aboveThreshold !== false) {
            $filtered = $last12MonthsConsultations->reject(function ($value, $key) use ($aboveThreshold) {
                return $key <= $aboveThreshold;
            });
        } else {
            $filtered = $last12MonthsConsultations;
        }

        $grouped = $filtered->groupBy(function ($item) {
            return Carbon::createFromFormat('Y-m-d', $item->date)->format('Y-m');
        });

        if ($grouped->count() < 3) {
            return true;
        }

        $months = $grouped->keys();

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
                return false;
            }
        }

        return true;
    }

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

    public function storePatient(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'medical_record_number' => 'required|unique:patients',
            'nik' => 'required|unique:patients',
            'sex' => 'required',
            'birthday' => 'required|date',
            'address' => 'required|string',
            'village_id' => 'required',
            'job' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ]);

        $patient = new Patient();

        $patient->name = $request->name;
        $patient->medical_record_number = $request->medical_record_number;
        $patient->nik = $request->nik;
        $patient->sex = $request->sex;
        $patient->birthday = $request->birthday;
        $patient->address = $request->address;
        $patient->village_id = $request->village_id;
        $patient->job = $request->job;
        $patient->phone_number = $request->phone_number;

        $patient->save();

        return redirect('/patient')->with('toast_success', 'Data pasien berhasil ditambah');
    }

    public function showEditPage($id)
    {
        $data['patient'] = Patient::find($id);
        $data['villages'] = Village::all();

        return view('patient.edit', $data);
    }

    public function updatePatient(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'medical_record_number' => 'required|unique:patients,medical_record_number,' . $request->id,
            'nik' => 'required|unique:patients,nik,' . $request->id,
            'sex' => 'required',
            'birthday' => 'required|string',
            'address' => 'required|string',
            'village_id' => 'required',
            'job' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ]);

        $patient = Patient::find($request->id);

        $patient->name = $request->name;
        $patient->medical_record_number = $request->medical_record_number;
        $patient->nik = $request->nik;
        $patient->sex = $request->sex;
        $patient->birthday = $request->birthday;
        $patient->address = $request->address;
        $patient->village_id = $request->village_id;
        $patient->job = $request->job;
        $patient->phone_number = $request->phone_number;

        $patient->save();

        return redirect("/patient/$request->id")->with('toast_success', 'Data pasien berhasil diubah');
    }

    public function destroyPatient(Request $request)
    {
        $patientId = $request->id;

        $patient = Patient::find($patientId);

        $patient->delete();

        return redirect('patient')->with('toast_success', 'Data pasien berhasil dihapus');
    }

    public function getAjaxDatatable(Request $request)
    {
        $patients = Patient::with('village');

        return DataTables::of($patients)
            ->addIndexColumn()
            ->editColumn('birthday', function (Patient $patient) {
                return Carbon::parse($patient->birthday)->age;
            })
            ->addColumn('status', function ($data) {
                $status = array();

                $last12MonthsConsultations = Consultation::getPatientConsultations($data->id, 'asc', 12);

                $hypertensionStatus = $this->checkHypertensionStatus($last12MonthsConsultations);
                if ($hypertensionStatus) {
                    $treatmentStatus = $this->checkTreatmentStatus($last12MonthsConsultations);
                } else {
                    $treatmentStatus = true;
                }

                if ($hypertensionStatus) {
                    $html = "<span class='badge bg-danger'>Tidak Terkendali</span>";
                    array_push($status, $html);
                } else {
                    $html = "<span class='badge bg-success'>Terkendali</span>";
                    array_push($status, $html);
                }

                if ($treatmentStatus) {
                    $html = "<span class='badge bg-success'>Teratur</span>";
                    array_push($status, $html);
                } else {
                    $html = "<span class='badge bg-danger'>Tidak Teratur</span>";
                    array_push($status, $html);
                }

                return implode(' ', $status);
            })
            ->addColumn('action', function ($row) {
                $html = "<a href='patient/$row->id' class='btn btn-xs btn-secondary'>View</a> ";
                return $html;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
