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

    public function getPatientWithVillage($id)
    {
        return $this->with('village')->find($id);
    }

    public function getPatientsForReport($startDate, $endDate)
    {
        return $this->with([
            'consultations' => function ($query) use ($endDate) {
                $query->select('id', 'patient_id', 'date', 'systole', 'diastole')
                    ->whereBetween('date', [Carbon::parse($endDate)->subYear()->format('Y-m-d'), Carbon::parse($endDate)->format('Y-m-d')])
                    ->orderBy('date', 'asc');
            }
        ])->select('id', 'sex', 'village_id')
            ->whereRelation('consultations', 'date', '>=', $startDate)
            ->whereRelation('consultations', 'date', '<=', $endDate)
            ->get();
    }
}
