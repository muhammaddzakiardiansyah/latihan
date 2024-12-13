<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class CheckupProgress
 *
 * @property int $id
 * @property int $appointment_id
 * @property int $service_id
 * @property int $status
 * @property \Iluminate\Support\Carbon|null $created_at
 * @property \Iluminate\Support\Carbon|null $updated_at
 *
*/

class CheckupProgress extends Model
{
    // increment primary key false
    public $incrementing = false;

    // allowed filed to insert or edit to database
    protected $fillable = [
        'appointment_id',
        'service_id',
        'status',
    ];

    // generate unik integer for primary key
    public static function boot(): void
    {
        parent::boot();
        static::creating(fn($model) => empty($model->id) ? $model->id = rand(10000, 100000) : '');
    }

    public function service(): HasOne
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'id', 'appointment_id');
    }
}
