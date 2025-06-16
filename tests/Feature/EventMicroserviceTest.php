<?php

namespace Tests\Feature;

use App\Jobs\StoreEventJob;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class EventMicroserviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_dispatches_event_store_job()
    {
        Queue::fake();

        $payload = [
            'user_id' => 123,
            'event_name' => 'clicked_on_a_button',
            'payload_version' => 1,
            'payload' => [
                'button' => 'submit',
                'color' => 'red'
            ]
        ];

        $response = $this->postJson('/api/v1/event', $payload);
        $response->assertStatus(201);

        // Make sure job dispatched
        // Queue::assertPushed(StoreEventJob::class, function ($job) use ($payload) {
        //     return $job->data['user_id'] === $payload['user_id'];
        // });

        Queue::assertPushed(StoreEventJob::class, function ($job) use ($payload) {
            return $job->getData()['user_id'] === $payload['user_id'];
        });

    }

    /** @test */
    public function it_inserts_event_via_job()
    {
        $payload = [
            'user_id' => 456,
            'event_name' => 'user_logged_in',
            'payload_version' => 1,
            'payload' => [
                'ip' => '127.0.0.1',
                'device' => 'iPhone'
            ]
        ];

        // Dispatch job manually for testing
        $job = new StoreEventJob($payload);
        $job->handle();

        $this->assertDatabaseHas('events', [
            'user_id' => 456,
            'event_name' => 'user_logged_in'
        ]);
    }

    /** @test */
    public function it_can_fetch_events_with_pagination_and_filters()
    {
        Event::factory()->count(30)->create([
            'user_id' => 789,
            'occurred_at' => now()->subDays(1),
        ]);

        Event::factory()->count(10)->create([
            'user_id' => 123,
            'occurred_at' => now(),
        ]);

        // Fetch first page for user_id 123
        $response = $this->getJson('/api/v1/events?user_id=123&limit=5&page=1');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'current_page',
            'last_page',
            'per_page',
            'total',
        ]);

        $json = $response->json();

        $this->assertEquals(1, $json['current_page']);
        $this->assertEquals(5, $json['per_page']);
        $this->assertEquals(10, $json['total']);
        $this->assertCount(5, $json['data']);
    }
}
