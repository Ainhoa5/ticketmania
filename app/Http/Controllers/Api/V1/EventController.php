<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Http\Resources\V1\EventCollection;
use App\Http\Resources\V1\EventResource;
use App\Filters\V1\EventFilter;
use App\Models\Event;
use App\Http\Requests\V1\StoreEventsRequest;
use App\Http\Requests\V1\UpdateEventRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
        // Upload images to Cloudinary
        $imageCover = $this->uploadImage($request->file('image_cover'));
        $imageBackground = $this->uploadImage($request->file('image_background'));

        // Create event in database
        $event = Event::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image_cover' => $imageCover,
            'image_background' => $imageBackground
        ]);

        return new EventResource($event);
    }

    /**
     * Upload image to Cloudinary and return its URL.
     */
    private function uploadImage($image)
    {
        if ($image) {
            // Log Cloudinary configuration
            \Log::info('Cloudinary configuration:');
            \Log::info(config('cloudinary'));

            // Upload image to Cloudinary
            $cloudinaryResponse = Cloudinary::upload($image->getPathname());

            // Get URL from Cloudinary response
            return $cloudinaryResponse->getSecurePath();
        }

        return null; // Return null if no image provided
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
    public function update(UpdateEventRequest $request, Event $event)
    {
        // Log request values
        \Log::info('Request values:', $request->all());

        // Upload images to Cloudinary if provided
        $imageCover = $this->uploadImage($request->file('image_cover'));
        $imageBackground = $this->uploadImage($request->file('image_background'));

        // Update event details
        $event->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image_cover' => $imageCover ?: $event->image_cover, // Keep existing image if not provided
            'image_background' => $imageBackground ?: $event->image_background, // Keep existing image if not provided
            // Add other fields as needed
        ]);

        return new EventResource($event);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully'], Response::HTTP_OK);
    }
}
