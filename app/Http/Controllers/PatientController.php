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
use Illuminate\Support\Facades\DB;
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
        $data['patient'] = (new Patient)->getPatientDetail($id);

        $data['consultations'] = Consultation::getPatientConsultations($id);

        $data['systole'] = [];
        $data['diastole'] = [];
        $data['date'] = [];

        foreach ($data['consultations']->reverse() as $consultation) {
            array_push($data['systole'], $consultation->systole);
            array_push($data['diastole'], $consultation->diastole);
            array_push($data['date'], $consultation->date);
        }

        $data['year'] = request('year') ?? Carbon::now()->year;

        $data['patientHabits'] = Habit::getPatientHabits($id, $data['year']);

        return view('patient.show', $data);
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
        $query = <<<EOD
        select patients.id, patients.name, medical_record_number, nik, sex, birthday, address, 
            v.name as village_name, job, phone_number, ifnull(monthcount, 0) as count_month, 
            ifnull(max(systole), 0) as max_systole, ifnull(max(diastole), 0) as max_diastole,
            if(ifnull(max(systole), 0) < 140 and ifnull(max(diastole), 0) < 90
            and ifnull(monthcount, 0) = 3, 0, 1) as is_hypertension,
            maks, if(maks >= 3, 1, 0) as is_routine
        from patients 
        left join
            (
            select patient_id, count(month) as monthcount
            from
                (
                select distinct patient_id, month(date) as month
                from consultations 
                where date
                between date_add(date_sub(last_day(now()), interval 3 month), interval 1 day)
                and last_day(now())
                ) cm
            group by patient_id
            ) mc on patients.id = mc.patient_id
        left join 
            (
            select distinct patient_id, systole, diastole
            from consultations 
            where date between date_add(date_sub(last_day(now()), interval 3 month), interval 1 day)
            and last_day(now())
            ) c on patients.id = c.patient_id
        left join
            (
            select patient_id, max(numMonths) as maks from (
            select patient_id, count(*) as numMonths
            from (select patient_id, ym, @ym, @person,
                        if(@person = patient_id  and @ym = ym - 1, @grp, @grp := @grp + 1) as grp,
                        @person := patient_id ,
                        @ym := ym
                from (select distinct patient_id, year(date)*12+month(date) as ym
                        from consultations r
                        where date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
                    ) r cross join
                    (select @person := '', @ym := 0, @grp := 0) const
                order by 1, 2
                ) pym
            group by patient_id, grp
            ) gpym group by patient_id
            ) x on patients.id = x.patient_id
        left join
            (
            select id, name from villages
            ) v on patients.village_id = v.id
        group by patients.id
        EOD;

        $patients = DB::select(DB::raw($query));

        return DataTables::of($patients)
            ->addIndexColumn()
            ->editColumn('birthday', function ($patient) {
                return Carbon::parse($patient->birthday)->age;
            })
            ->addColumn('status', function ($patient) {
                $status = [];

                if ($patient->is_hypertension) {
                    $html = "<span class='badge bg-danger'>Tidak Terkendali</span>";
                    array_push($status, $html);
                } else {
                    $html = "<span class='badge bg-success'>Terkendali</span>";
                    array_push($status, $html);
                }

                if ($patient->is_routine) {
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
