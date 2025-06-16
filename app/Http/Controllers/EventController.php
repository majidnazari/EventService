<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Jobs\StoreEventJob;

use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    protected EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function store(StoreEventRequest $request): JsonResponse
    {

        // Dispatch job to queue
        dispatch(new StoreEventJob($request->validated())); // this is added instead of normal service because too many request of insertion

        // Return fast response
        return response()->json(['success' => true, 'message' => 'Event queued'], 201);

        //$event = $this->eventService->store($request->validated());

        // return response()->json([
        //     'success' => true,
        //     'event_id' => $event->id,
        // ], 201);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['from', 'user_id']);
        $limit = $request->input('limit', 50);

        $events = $this->eventService->fetch($filters, $limit);

        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreEventRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
