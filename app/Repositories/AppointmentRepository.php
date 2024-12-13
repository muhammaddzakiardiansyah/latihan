<?php

namespace App\Repositories;

use App\Models\Appointment;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function addAppointment(array $dataAppointment)
    {
        return Appointment::create($dataAppointment);
    }

    public function getDetailAppointment(string $id)
    {
        return Appointment::with(['patient:id,name', 'diagnose:id,name', 'checkupProgress', 'checkupProgress.service:id,name'])->find($id);
    }

    public function editAppointment(array $dataAppointment, string $id)
    {
        $appointment = Appointment::with(['patient:id,name', 'diagnose:id,name', 'checkupProgress', 'checkupProgress.service:id,name'])->find($id);
        $appointment->update($dataAppointment);
        return $appointment;
    }
}
