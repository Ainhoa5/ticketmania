<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TicketCollection;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Http\Requests\V1\StoreTicketsRequest;
use App\Http\Requests\V1\UpdateTicketRequest;
use App\Filters\V1\TicketFilter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new TicketFilter();
        $filterItems = $filter->transform($request); // Converts request parameters into a format suitable for query filtering

        $tickets = Ticket::where($filterItems);

        return new TicketCollection($tickets->paginate()->appends($request->query()));
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
    public function store(StoreTicketsRequest $request)
    {
        return new TicketResource(Ticket::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $tickets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        // Update using only validated data.
        $ticket->update($request->validated());
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {

        $ticket->delete();
        return response()->json(['message' => 'Event deleted successfully'], Response::HTTP_OK);
    }
}
