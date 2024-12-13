<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Service
 *
 * @property int $id
 * @property string $name
 * @property \Iluminate\Support\Carbon|null $created_at
 * @property \Iluminate\Support\Carbon|null $updated_at
 *
*/

class Service extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'name',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating(fn($model) => empty($model->id) ? $model->id = rand(10000, 100000) : '');
    }

    public function checkupProgress(): BelongsTo
    {
        return $this->belongsTo(CheckupProgress::class, 'service_id', 'id');
    }
}
