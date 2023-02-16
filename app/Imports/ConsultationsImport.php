<?php

namespace App\Imports;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Village;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ConsultationsImport implements ToModel, WithBatchInserts, WithUpserts, WithUpsertColumns, WithHeadingRow
{

    use Importable;

    public function model(array $row)
    {
        if (!isset($row['no'])) {
            return null;
        }

        if (strcasecmp($row['diagnosa'], 'i10') != 0 && strcasecmp($row[36], 'i10') != 0 && strcasecmp($row[38], 'i10') != 0) {
            return null;
        }

        $medicalRecordNumber = ltrim($row['no_rm'], "`");
        $patient = Patient::where('medical_record_number', $medicalRecordNumber)->first();

        if (!$patient) {
            $nik = ltrim($row['no_ktp'], "`");
            if (empty($nik)) {
                $nik = null;
            }

            $village = Village::where('name', $row['desa'])->firstOrCreate([
                'name' => $row['desa']
            ]);

            $patient = new Patient;
            $patient->name = $row['nama'];
            $patient->medical_record_number = $medicalRecordNumber;
            $patient->nik = $nik;
            $patient->sex = $row['lp'];
            $patient->birthday = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']));
            $patient->address = $row['alamat'];
            $patient->village_id = $village->id;
            $patient->job = $row['pekerjaan'];
            $patient->phone_number = $row['no_hp'];
            $patient->save();
        }

        $date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal']));

        $bloodtension = $row['tensi'];
        $split = explode("/", $bloodtension);
        $systole = empty($split[0]) ? 0 : $split[0];
        $diastole = empty($split[1]) ? 0 : $split[1];

        return new Consultation([
            'patient_id' => $patient->id,
            'date' => $date,
            'systole' => $systole,
            'diastole' => $diastole,
            'medicine' => $row['terapi'],
            'note' => $row['keluhan'],
        ]);
    }

    public function headingRow(): int
    {
        return 4;
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
