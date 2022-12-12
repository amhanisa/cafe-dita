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

    public function getPatientConsultations($patientId, $orderBy = 'desc', $limitMonths = null)
    {
        return $this->where('patient_id', $patientId)
            ->when($limitMonths, function ($query) use ($limitMonths) {
                $query->whereBetween('date', [Carbon::now()->subMonths($limitMonths)->format('Y-m-d'), Carbon::now()->format('Y-m-d')]);
            })
            ->orderBy('date', $orderBy)
            ->get();
    }

    public function getConsultationWithPatient($consultationId)
    {
        return $this->with('patient')->find($consultationId);
    }
}
