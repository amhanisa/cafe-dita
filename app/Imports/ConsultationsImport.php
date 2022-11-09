<?php

namespace App\Imports;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ConsultationsImport implements ToCollection, WithHeadingRow
{
    private $patients, $villages;

    public function __construct()
    {
        $this->patients = Patient::select('id', 'medical_record_number')->get();
        $this->villages = Village::select('id', 'name')->get();
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $medicalRecordNumber = ltrim($row['no_rm'], "`");
            $patient = $this->patients->where('medical_record_number', $medicalRecordNumber)->first();

            if (!$patient) {
                $nik = ltrim($row['no_ktp'], "`");
                if (empty($nik)) {
                    $nik = null;
                }
                $village = $this->villages->where('name', $row['desa'])->first();

                $patient = new Patient;
                $patient->name = $row['nama'];
                $patient->medical_record_number = $medicalRecordNumber;
                $patient->nik = $nik;
                $patient->sex = $row['lp'];
                $patient->birthday = Carbon::parse($row['tanggal_lahir'])->toDate();
                $patient->address = $row['alamat'];
                $patient->village_id = $village->id;
                $patient->job = $row['pekerjaan'];
                $patient->phone_number = $row['no_hp'];
                $patient->save();
            }

            $date = Carbon::parse($row['tanggal'])->toDate();

            $bloodtension = $row['tensi'];
            $split = explode("/", $bloodtension);
            $systole = empty($split[0]) ? 0 : $split[0];
            $diastole = empty($split[1]) ? 0 : $split[1];

            Consultation::updateOrCreate([
                'patient_id' => $patient->id,
                'date' => $date
            ], [
                'systole' => $systole,
                'diastole' => $diastole,
                'medicine' => 'apaya',
                'note' => $row['terapi'],
            ]);
        }
    }

    public function headingRow(): int
    {
        return 5;
    }
}
