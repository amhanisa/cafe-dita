<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'date', 'systole', 'diastole', 'medicine', 'note'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public static function getPatientConsultations($patient_id, $orderBy = 'desc', $limitMonths = null)
    {
        return Consultation::where('patient_id', $patient_id)
            ->when($limitMonths, function ($query) use ($limitMonths) {
                $query->whereDate('date', '>', \Carbon\Carbon::now()->subMonths($limitMonths));
            })
            ->orderBy('date', $orderBy)
            ->get();
    }

    public static function getConsultationWithPatient($consultation_id)
    {
        return Consultation::with('patient')->find($consultation_id);
    }
}
