<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class TicketFilter extends ApiFilter {
    protected $safeParams = [
        'id' => ['eq'],
        'concertId' => ['eq'],
        'userId' => ['eq'],
        'createdAt' => ['eq', 'lt', 'gt'],
        'updatedAt' => ['eq', 'lt', 'gt']
    ];

    protected $columnMap = [
        'concertId' => 'concert_id',
        'userId' => 'user_id',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>='
    ];
}
