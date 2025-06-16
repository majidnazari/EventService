<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventService
{
    public function store(array $data): Event
    {
        return Event::create([
            'user_id' => $data['user_id'],
            'event_name' => $data['event_name'],
            'payload_version' => $data['payload_version'] ?? 1,
            'payload' => $data['payload'] ?? [],
            'occurred_at' => now(),
        ]);
    }

    public function fetch(array $filters, int $limit): LengthAwarePaginator
    {
        $query = Event::query();

        if (!empty($filters['from'])) {
            $query->where('occurred_at', '>=', $filters['from']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->orderByDesc('occurred_at')->paginate($limit);
    }
}
