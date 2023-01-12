<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsultationsTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $admin, $patient;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::find(1);
        $this->patient = Patient::create([
            'name' => 'Azka Muhammad',
            'medical_record_number' => '12345',
            'NIK' => '3213451212090001',
            'birthday' => '1998-03-31',
            'sex' => 'L',
            'address' => 'RT 01 RW 01',
            'village_id' => 1,
        ]);
    }

    /** @test */
    public function add_consultations_without_parameter()
    {
        $response = $this->actingAs($this->admin)->post('/consultation/' . $this->patient->id . '/store');

        $response->assertSessionHasErrors([
            'date' => 'Isian Tanggal wajib diisi',
            'systole' => 'Isian Sistol wajib diisi',
            'diastole' => 'Isian Diastol wajib diisi'
        ]);
    }

    /** @test */
    public function add_consultations_with_parameter()
    {
        $response = $this->actingAs($this->admin)->post(
            '/consultation/' . $this->patient->id . '/store',
            [
                'patient_id' => $this->patient->id,
                'date' => now(),
                'systole' => 135,
                'diastole' => 80,
            ]
        );

        $response->assertSessionHas([
            'toast_success' => 'Data konsultasi berhasil ditambah'
        ]);
    }
}
