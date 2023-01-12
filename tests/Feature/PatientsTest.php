<?php

namespace Tests\Feature;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientsTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::find(1);
    }

    /** @test */
    public function test_detail_patient_with_hypertension()
    {
        $patient = Patient::create([
            'name' => 'Azka Muhammad',
            'medical_record_number' => '12345',
            'NIK' => '3213451212090001',
            'birthday' => '1998-03-31',
            'sex' => 'L',
            'address' => 'RT 01 RW 01',
            'village_id' => 1,
        ]);

        $response = $this->actingAs($this->admin)->get('/patient/' . $patient->id);

        $response->assertSeeInOrder(['Status Berobat', 'Tidak Teratur', 'Status Hipertensi', 'Tidak Terkendali']);
    }

    /** @test */
    public function test_detail_patient_without_hypertension()
    {
        $patient = Patient::create([
            'name' => 'Azka Muhammad',
            'medical_record_number' => '12345',
            'NIK' => '3213451212090001',
            'birthday' => '1998-03-31',
            'sex' => 'L',
            'address' => 'RT 01 RW 01',
            'village_id' => 1,
        ]);

        foreach (range(1, 5) as $index) {
            Consultation::create([
                'patient_id' => $patient->id,
                'date' => now()->subMonths($index),
                'systole' => 135,
                'diastole' => 80
            ]);
        }

        $response = $this->actingAs($this->admin)->get('/patient/' . $patient->id);

        $response->assertSeeInOrder(['Status Berobat', 'Teratur', 'Status Hipertensi', 'Terkendali']);
        $response->assertDontSeeText('Tidak Teratur');
        $response->assertDontSeeText('Tidak Terkendali');
    }
}
