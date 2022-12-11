<?php

namespace App\Models;

use Carbon\Carbon;
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

    public static function getPatientConsultations($patientId, $orderBy = 'desc', $limitMonths = null)
    {
        return Consultation::where('patient_id', $patientId)
            ->when($limitMonths, function ($query) use ($limitMonths) {
                $query->whereBetween('date', [Carbon::now()->subMonths($limitMonths)->startOfMonth()->format('Y-m-d'), Carbon::now()->subMonths(1)->endOfMonth()->format('Y-m-d')]);
            })
            ->orderBy('date', $orderBy)
            ->get();
    }

    public static function getConsultationWithPatient($consultationId)
    {
        return Consultation::with('patient')->find($consultationId);
    }
}
