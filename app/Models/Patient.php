<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'medical_record_number', 'nik', 'sex', 'birthday', 'address', 'village', 'job', 'phone_number'];

    public function consultation()
    {
        return $this->hasMany(Consultation::class);
    }
}
