<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository implements PatientRepositoryInterface
{
    public function addPatient(array $dataPatient)
    {
        return Patient::create($dataPatient);
    }
}
