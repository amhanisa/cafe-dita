<?php

namespace Tests\Feature;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IntegrationTest extends TestCase
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
    public function path_1_not_hypertension()
    {
        foreach (range(1, 3) as $index) {
            Consultation::create([
                'patient_id' => $this->patient->id,
                'date' => now()->subMonths($index),
                'systole' => 120,
                'diastole' => 80,
            ]);
        }

        $response = $this->actingAs($this->admin)->get('/patient/' . $this->patient->id);

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Status Berobat', 'Teratur', 'Status Hipertensi', 'Terkendali']);
        $response->assertDontSeeText('Tidak Teratur');
        $response->assertDontSeeText('Tidak Terkendali');
    }

    /** @test */
    public function path_2_hypertension_with_0_consultation()
    {
        $response = $this->actingAs($this->admin)->get('/patient/' . $this->patient->id);

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Status Berobat', 'Tidak Teratur', 'Status Hipertensi', 'Tidak Terkendali']);
    }

    /** @test */
    public function path_3_hypertension_with_3_months_consultations()
    {
        foreach (range(1, 3) as $index) {
            Consultation::create([
                'patient_id' => $this->patient->id,
                'date' => now()->subDays($index),
                'systole' => 150,
                'diastole' => 100
            ]);
        }

        $response = $this->actingAs($this->admin)->get('/patient/' . $this->patient->id);

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Status Berobat', 'Tidak Teratur', 'Status Hipertensi', 'Tidak Terkendali']);
    }

    /** @test */
    public function path_4_hypertension_with_2_months_consultations()
    {
        foreach (range(1, 3) as $index) {
            Consultation::create([
                'patient_id' => $this->patient->id,
                'date' => now()->subDays($index * 13),
                'systole' => 150,
                'diastole' => 100
            ]);
        }

        $response = $this->actingAs($this->admin)->get('/patient/' . $this->patient->id);

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Status Berobat', 'Tidak Teratur', 'Status Hipertensi', 'Tidak Terkendali']);
    }

    /** @test */
    public function path_5_hypertension_with_2_months_not_consecutive_consultations()
    {

        Consultation::create([
            'patient_id' => $this->patient->id,
            'date' => now()->subMonths(5),
            'systole' => 150,
            'diastole' => 100
        ]);
        Consultation::create([
            'patient_id' => $this->patient->id,
            'date' => now()->subMonths(5)->addDay(),
            'systole' => 150,
            'diastole' => 100
        ]);
        Consultation::create([
            'patient_id' => $this->patient->id,
            'date' => now()->subMonth(1),
            'systole' => 150,
            'diastole' => 100
        ]);

        $response = $this->actingAs($this->admin)->get('/patient/' . $this->patient->id);

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Status Berobat', 'Tidak Teratur', 'Status Hipertensi', 'Tidak Terkendali']);
    }

    /** @test */
    public function path_6_hypertension_with_6_months_not_consecutive_consultations()
    {
        foreach (range(1, 6) as $index) {
            Consultation::create([
                'patient_id' => $this->patient->id,
                'date' => now()->subMonths($index * 2),
                'systole' => 150,
                'diastole' => 100
            ]);
        }

        $response = $this->actingAs($this->admin)->get('/patient/' . $this->patient->id);

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Status Berobat', 'Tidak Teratur', 'Status Hipertensi', 'Tidak Terkendali']);
    }
}
