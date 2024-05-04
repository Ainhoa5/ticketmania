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
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request)
    {
        $concertId = $request->input('concertId');
        $paymentMethodId = $request->input('payment_method_id');  // Assuming this is passed from the frontend
        $ticketQuantity = $request->input('ticketQuantity', 1); // Default to 1 ticket if quantity is not specified

        return DB::transaction(function () use ($request, $concertId, $paymentMethodId, $ticketQuantity) {
            $userId = $request->user()->id;
            $concert = \App\Models\Concert::lockForUpdate()->find($concertId);

            if ($concert && $concert->tickets_sold < $concert->capacity_total) {
                // Initialize Stripe Client
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

                // Attempt to charge the payment method
                try {
                    // Calculate total amount for all tickets
                    $totalAmount = $concert->price * $ticketQuantity * 100; // Convert amount to cents

                    // Create payment intent for multiple tickets
                    $paymentIntent = $stripe->paymentIntents->create([
                        'amount' => $totalAmount,
                        'currency' => 'usd',
                        'payment_method' => $paymentMethodId,
                        'confirm' => true,
                        'return_url' => 'http://localhost:3000/payment-complete',
                        'automatic_payment_methods' => ['enabled' => true],
                        'use_stripe_sdk' => true,
                    ]);

                    // Check if the payment is successfully confirmed
                    if ($paymentIntent->status === 'succeeded') {
                        // Increment tickets sold count for the concert
                        $concert->tickets_sold += $ticketQuantity;
                        $concert->save();

                        // Create multiple tickets and associated payments
                        $tickets = [];
                        for ($i = 0; $i < $ticketQuantity; $i++) {
                            $ticket = Ticket::create([
                                'concert_id' => $concertId,
                                'user_id' => $userId
                            ]);

                            $payment = \App\Models\Payment::create([
                                'user_id' => $userId,
                                'ticket_id' => $ticket->id,
                                'amount' => $concert->price,
                                'status' => 'completed',
                                'stripe_payment_id' => $paymentIntent->id
                            ]);

                            $tickets[] = $ticket;
                        }

                        return response()->json(['tickets' => $tickets], 200);
                    } else {
                        return response()->json(['message' => 'Payment failed'], 402);
                    }
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    // Handle exceptions from Stripe
                    return response()->json(['message' => 'Stripe API error: ' . $e->getMessage()], 500);
                }
            } else {
                return response()->json([
                    'message' => 'No tickets available or concert does not exist',
                    'details' => 'Checked concert ID: ' . $concertId . ', Tickets sold: ' . ($concert ? $concert->tickets_sold : 'N/A') . ', Capacity: ' . ($concert ? $concert->capacity_total : 'N/A')
                ], 400);
            }
        });
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
