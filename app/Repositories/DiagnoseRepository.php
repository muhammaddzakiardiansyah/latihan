<?php

namespace App\Repositories;

use App\Models\Diagnose;

class DiagnoseRepository implements DiagnoseRepositoryInterface
{
    public function addDiagnose(array $dataDiagnose)
    {
        return Diagnose::create($dataDiagnose);
    }
}
