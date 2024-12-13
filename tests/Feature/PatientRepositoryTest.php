<?php

namespace Tests\Feature;

use App\Repositories\PatientRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $patientRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->patientRepository = app(PatientRepositoryInterface::class);
    }

    public function test_create_patient(): void
    {
        $rules = [
            'name' => 'Muhammad Dzaki',
        ];

        $this->patientRepository->addPatient($rules);

        $this->assertDatabaseHas('patients', [
            'name' => 'Muhammad Dzaki',
        ]);
    }
}
