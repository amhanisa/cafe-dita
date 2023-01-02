<?php

namespace App\Imports;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Village;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ConsultationsImport implements ToModel, WithBatchInserts, WithUpserts, WithUpsertColumns, WithHeadingRow
{
    public function model(array $row)
    {
        $medicalRecordNumber = ltrim($row['no_rm'], "`");
        $patient = Patient::where('medical_record_number', $medicalRecordNumber)->first();

        if (!$patient) {
            $nik = ltrim($row['no_ktp'], "`");
            if (empty($nik)) {
                $nik = null;
            }
            $village = Village::where('name', $row['desa'])->first();

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

        return new Consultation([
            'patient_id' => $patient->id,
            'date' => $date,
            'systole' => $systole,
            'diastole' => $diastole,
            'medicine' => $row['tindakan'],
            'note' => $row['terapi'],
        ]);
    }

    public function headingRow(): int
    {
        return 5;
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function uniqueBy()
    {
        return ['patient_id', 'date'];
    }

    public function upsertColumns()
    {
        return ['systole', 'diastole', 'medicine', 'note'];
    }
}
