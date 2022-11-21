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
        $data['patient'] = Patient::with('village')->find($id);

        $data['consultations'] = Consultation::getPatientConsultations($id);

        $last3MonthsConsultations = Consultation::getPatientConsultations($id, 'asc', 3);

        $last12MonthsConsultations = Consultation::getPatientConsultations($id, 'asc', 12);

        $data['hypertensionStatus'] = $this->checkHypertensionStatus($last3MonthsConsultations);
        $data['treatmentStatus'] = $this->checkTreatmentStatus($last12MonthsConsultations);

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

    // Cara menentukan status hipertensi
    // Cek data konsultasi 3 bulan terakhir
    // Jika selama 3 bulan nilainya dibawah batas 140/90
    // Maka ditetapkan hipertensi terkendali (false)
    // Jika nilai diatas batas 140/90
    // Maka ditetapkan hipertensi tidak terkendali (true)
    private function checkHypertensionStatus($last3MonthsConsultations)
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
    private function checkTreatmentStatus($last12MonthsConsultations)
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

    private function getMonth($string)
    {
        return (int)substr($string, 5, 2);
    }

    private function getYear($string)
    {
        return (int)substr($string, 0, 4);
    }

    public function storePatient(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'medical_record_number' => 'required',
            'nik' => 'required',
            'sex' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'village_id' => 'required',
            'job' => 'required',
            'phone_number' => 'string',
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
            'medical_record_number' => 'required',
            'nik' => 'required',
            'sex' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'village_id' => 'required',
            'job' => 'required',
            'phone_number' => 'string',
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

                $last3MonthsConsultations = Consultation::getPatientConsultations($data->id, 'asc', 3);

                $last12MonthsConsultations = Consultation::getPatientConsultations($data->id, 'asc', 12);

                $hypertensionStatus = $this->checkHypertensionStatus($last3MonthsConsultations);
                $treatmentStatus = $this->checkTreatmentStatus($last12MonthsConsultations);

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
