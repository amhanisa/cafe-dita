<?php

namespace App\Http\Controllers;

use App\DataTables\PatientsDataTable;
use App\Models\Consultation;
use App\Models\Habit;
use App\Models\Patient;
use App\Models\PatientHabit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $patients = Patient::query();

            return DataTables::of($patients)
                ->addIndexColumn()
                ->editColumn('birthday', function (Patient $patient) {
                    return Carbon::parse($patient->birthday)->age;
                })
                ->addColumn('status', function (Patient $patient) {
                    $consultations = Consultation::where('patient_id', $patient->id)->orderBy('date', 'desc')->get();
                    $data['consultations']  = $consultations;

                    $averageSystole = $consultations->avg('systole');
                    $averageDiastole = $consultations->avg('diastole');

                    if ($averageSystole >= 140 || $averageDiastole >= 90) {
                        $html = "<span class='badge bg-danger'>Tidak Terkendali</span>";
                    } else {
                        $html = "<span class='badge bg-success'>Terkendali</span>";
                    }

                    $last12Months = Consultation::where('patient_id', $patient->id)->whereDate('date', '>', \Carbon\Carbon::now()->subYear())->orderBy('date', 'asc')->get();

                    if (count($last12Months) > 0) {
                        if ($this->calculate($last12Months)) {
                            $html .= "<span class='badge bg-success'>Teratur</span>";
                        } else {
                            $html .= "<span class='badge bg-danger'>Tidak Teratur</span>";
                        }
                    } else {
                        $html .= "<span class='badge bg-danger'>Belum Berobat</span>";
                    }

                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $html = "<a href='patient/$row->id' class='btn btn-xs btn-secondary'>View</a> ";
                    return $html;
                })
                ->rawColumns(['status', 'action'])
                ->toJson();
        }

        return view('patient.index');
    }

    public function add()
    {
        return view('patient.add');
    }

    public function show($id)
    {
        $data['patient'] = Patient::find($id);

        $consultations = Consultation::where('patient_id', $id)->orderBy('date', 'desc')->get();
        $data['consultations']  = $consultations;

        $averageSystole = $consultations->avg('systole');
        $averageDiastole = $consultations->avg('diastole');

        if ($averageSystole >= 140 || $averageDiastole >= 90) {
            $hypertensionStatus = true;
        } else {
            $hypertensionStatus = false;
        }

        $last12Months = Consultation::where('patient_id', $id)->whereDate('date', '>', \Carbon\Carbon::now()->subYear())->orderBy('date', 'asc')->get();

        $data['berobatStatus'] = $this->calculate($last12Months);
        $data['hypertensionStatus'] = $hypertensionStatus;

        $data['patientHabits'] = Habit::with(['patientHabit' => function ($query) use ($id) {
            $query->where('patient_id', $id)->where('year', 2022)->orderBy('month', 'asc');
        }])->get();

        return view('patient.show', $data);
    }

    function getTensionHistory(Request $request)
    {
        $consultations = Consultation::where('patient_id', $request->patientId)->orderBy('date', 'asc')->get();

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

    function calculate($last12Months)
    {
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

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'medical_record_number' => 'required',
            'nik' => 'required',
            'sex' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'village' => 'required',
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
        $patient->village = $request->village;
        $patient->job = $request->job;
        $patient->phone_number = $request->phone_number;

        $patient->save();

        return redirect('/patient');
    }

    public function showEditPage($id)
    {
        $data['patient'] = Patient::find($id);

        return view('patient.edit', $data);
    }

    public function save(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'medical_record_number' => 'required',
            'nik' => 'required',
            'sex' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'village' => 'required',
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
        $patient->village = $request->village;
        $patient->job = $request->job;
        $patient->phone_number = $request->phone_number;

        $patient->save();

        return redirect("/patient/$request->id");
    }

    public function destroy(Request $request)
    {
        $patientId = $request->id;

        $patient = Patient::find($patientId);

        $patient->delete();

        return redirect('patient');
    }
}
