<?php

namespace App\Repositories;

interface AppointmentRepositoryInterface
{
    public function addAppointment(array $dataAppointment);
    public function getDetailAppointment(string $id);
    public function editAppointment(array $dataAppointment, string $id);
}
