<?php

namespace Tests\Feature;

use App\Repositories\ServiceRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $serviceRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceRepository = app(ServiceRepositoryInterface::class);
    }

    public function test_add_service(): void
    {
        $rules = [
            'name' => 'Kontrol',
        ];

        $this->serviceRepository->addService($rules);

        $this->assertDatabaseHas('services', [
            'name' => 'Kontrol',
        ]);
    }
}
