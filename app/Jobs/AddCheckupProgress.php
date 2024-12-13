<?php

namespace App\Jobs;

use App\Models\CheckupProgress;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AddCheckupProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $dataCheckupProgress;

    /**
     * Create a new job instance.
     */
    public function __construct($dataCheckupProgress)
    {
        $this->dataCheckupProgress = $dataCheckupProgress;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        CheckupProgress::create([
            'appointment_id' => $this->dataCheckupProgress['appointment_id'],
            'service_id' => $this->dataCheckupProgress['service_id'],
        ]);
    }

    public function failed(\Exception $exception)
    {
        Log::error('AddCheckupProgress failed: ' . $exception->getMessage());
    }
}
