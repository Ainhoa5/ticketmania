<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class EventFilter extends ApiFilter {
    protected $safeParams = [
        'id' => ['eq'],
        'name' => ['eq', 'like'],
        'description' => ['eq', 'like'],
        'createdAt' => ['eq', 'lt', 'gt'],
        'updatedAt' => ['eq', 'lt', 'gt']
    ];

    protected $columnMap = [
        'imageCover' => 'image_cover',
        'imageBackground' => 'image_background',
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
