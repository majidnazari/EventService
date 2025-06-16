<?php

namespace App\Jobs;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Event::create([
            'user_id' => $this->data['user_id'],
            'event_name' => $this->data['event_name'],
            'payload_version' => $this->data['payload_version'] ?? 1,
            'payload' => $this->data['payload'] ?? [],
            'occurred_at' => now()
        ]);
    }

    public function getData(): array
    {
        return $this->data;
    }

}
