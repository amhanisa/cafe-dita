<?php

namespace Tests\Feature;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportsTest extends TestCase
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
    public function open_report_page()
    {
        $response = $this->actingAs($this->admin)->get('/report');

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Filter', 'Tanggal Awal', 'Tanggal Akhir', 'Cari']);
    }

    /** @test */
    public function open_report_page_with_false_date()
    {
        $end_date = now()->addMonth()->format('Y-m-d');
        $response = $this->actingAs($this->admin)->get("/report?start_date=&end_date=$end_date");

        $response->assertSessionHasErrors([
            'start_date' => 'Isian Tanggal Awal wajib diisi',
            'end_date' => 'Tanggal Akhir maksimal diisi tanggal hari ini'
        ]);
    }

    /** @test */
    public function open_report_page_without_patient()
    {
        $start_date = now()->subMonth()->format('Y-m-d');
        $end_date = now()->format('Y-m-d');
        $response = $this->actingAs($this->admin)->get("/report?start_date=$start_date&end_date=$end_date");

        $this->assertEquals(0, $response['hypertensionCount']);
        $this->assertEquals(0, $response['notHypertensionCount']);
    }

    /** @test */
    public function open_report_page_with_hypertension_patient()
    {
        Consultation::create([
            'patient_id' => $this->patient->id,
            'date' => now()->subDay(),
            'systole' => 140,
            'diastole' => 90,
        ]);

        $start_date = now()->subMonth()->format('Y-m-d');
        $end_date = now()->format('Y-m-d');
        $response = $this->actingAs($this->admin)->get("/report?start_date=$start_date&end_date=$end_date");

        $this->assertEquals(1, $response['hypertensionCount']);
        $this->assertEquals(0, $response['notHypertensionCount']);
    }

    /** @test */
    public function open_report_page_with_not_hypertension_patient()
    {
        foreach (range(1, 3) as $index) {
            Consultation::create([
                'patient_id' => $this->patient->id,
                'date' => now()->subMonths($index),
                'systole' => 135,
                'diastole' => 80,
            ]);
        }

        $start_date = now()->subMonth()->format('Y-m-d');
        $end_date = now()->format('Y-m-d');
        $response = $this->actingAs($this->admin)->get("/report?start_date=$start_date&end_date=$end_date");

        $this->assertEquals(0, $response['hypertensionCount']);
        $this->assertEquals(1, $response['notHypertensionCount']);
    }
}
