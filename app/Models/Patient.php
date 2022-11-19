<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'medical_record_number', 'nik', 'sex', 'birthday', 'address', 'village_id', 'job', 'phone_number'];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public static function getPatientsForReport($startDate, $endDate, $minAge, $maxAge)
    {
        $query = <<<EOD
        SELECT id FROM (
            SELECT *, FLOOR (DATEDIFF(NOW(),birthday) /365.2425) AS 'age' FROM patients
            WHERE id IN (
                SELECT DISTINCT(patient_id) FROM consultations
                WHERE DATE > "$startDate"
                AND DATE < "$endDate"
                ORDER BY patient_id
            )
        ) AS p
        WHERE age > $minAge AND age < $maxAge
        EOD;

        $patientList = DB::select(DB::raw($query));

        $patientsId = array_column($patientList, 'id');

        return (new static)::with(['consultations' => function ($query) use ($endDate) {
            $query->whereBetween('date', [Carbon::parse($endDate)->subYear(), $endDate])->orderBy('date', 'asc');
        }])->whereIn('id', $patientsId)->get();
    }
}
