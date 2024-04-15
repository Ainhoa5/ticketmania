<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use App\Http\Resources\V1\ConcertCollection;
use App\Http\Resources\V1\ConcertResource;
use App\Models\Concert;
use App\Http\Requests\StoreConcertsRequest;
use App\Http\Requests\UpdateConcertsRequest;
use App\Filters\V1\ConcertFilter;
use Illuminate\Http\Request;
class ConcertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ConcertFilter();
        $filterItems = $filter->transform($request); // Transforms query parameters into filter criteria

        $concerts = Concert::where($filterItems); // Applies filters to the query

        return new ConcertCollection($concerts->paginate()->appends($request->query())); // Returns paginated results
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
    public function store(StoreConcertsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Concert $concerts)
    {
        return new ConcertResource($concerts);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Concert $concerts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConcertsRequest $request, Concert $concerts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Concert $concerts)
    {
        //
    }
}
