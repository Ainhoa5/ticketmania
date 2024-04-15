<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class PaymentFilter extends ApiFilter {
    protected $safeParams = [
        'id' => ['eq'],
        'userId' => ['eq'],
        'ticketId' => ['eq'],
        'amount' => ['eq', 'lt', 'gt'],
        'status' => ['eq'],
        'stripePaymentId' => ['eq'],
        'createdAt' => ['eq', 'lt', 'gt'],
        'updatedAt' => ['eq', 'lt', 'gt']
    ];

    protected $columnMap = [
        'userId' => 'user_id',
        'ticketId' => 'ticket_id',
        'stripePaymentId' => 'stripe_payment_id',
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
