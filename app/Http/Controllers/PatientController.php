<?php

namespace App\Http\Controllers;

use App\DataTables\PatientsDataTable;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $patients = Patient::all();

            return DataTables::of($patients)
                ->addIndexColumn()
                ->editColumn('birthday', function (Patient $patient) {
                    return Carbon::parse($patient->birthday)->age;
                })
                ->addColumn('status', function ($row) {
                    $html = "<span class='badge bg-success'>Berobat Teratur</span><span class='badge bg-success'>Terkendali</span>";
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

        return view('patient.show', $data);
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
            'phone_number' => 'numeric',
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
    }
}
