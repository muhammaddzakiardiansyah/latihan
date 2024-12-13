<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function addService(array $dataService)
    {
        return Service::create($dataService);
    }
}
