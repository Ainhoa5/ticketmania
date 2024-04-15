<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Http\Resources\V1\EventCollection;
use App\Http\Resources\V1\EventResource;
use App\Filters\V1\EventFilter;
use App\Models\Concert;
use App\Models\Event;
use App\Http\Requests\StoreEventsRequest;
use App\Http\Requests\UpdateEventsRequest;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new EventFilter();
        $filterItems = $filter->transform($request); // Transforms query parameters into filter criteria

        $events = Event::where($filterItems); // Applies filters to the query

        return new EventCollection($events->paginate()->appends($request->query())); // Returns paginated results
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
    public function store(StoreEventsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return new EventResource($event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $events)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventsRequest $request, Event $events)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $events)
    {
        //
    }
}
