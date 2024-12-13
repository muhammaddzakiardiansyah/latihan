<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Diagnose
 *
 * @property int $id
 * @property int $patient_id
 * @property int $diagnose_id
 * @property int $status
 * @property \Iluminate\Support\Carbon|null $created_at
 * @property \Iluminate\Support\Carbon|null $updated_at
 *
*/

class Appointment extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'patient_id',
        'diagnose_id',
        'status',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating(fn($model) => empty($model->id) ? $model->id = rand(10000, 100000) : '');
    }

    public function diagnose(): HasOne
    {
        return $this->hasOne(Diagnose::class, 'id', 'diagnose_id');
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }

    public function checkupProgress(): HasOne
    {
        return $this->hasOne(CheckupProgress::class, 'appointment_id', 'id');
    }
}
