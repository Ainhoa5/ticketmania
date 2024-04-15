<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class ConcertFilter extends ApiFilter {
    protected $safeParams = [
        'id' => ['eq'],
        'eventId' => ['eq'],
        'date' => ['eq', 'lt', 'gt'],
        'location' => ['eq', 'like'],
        'capacityTotal' => ['eq', 'lt', 'gt'],
        'ticketsSold' => ['eq', 'lt', 'gt'],
        'price' => ['eq', 'lt', 'gt'],
        'createdAt' => ['eq', 'lt', 'gt'],
        'updatedAt' => ['eq', 'lt', 'gt']
    ];

    protected $columnMap = [
        'eventId' => 'event_id',
        'capacityTotal' => 'capacity_total',
        'ticketsSold' => 'tickets_sold',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'like' => 'LIKE'
    ];
}
