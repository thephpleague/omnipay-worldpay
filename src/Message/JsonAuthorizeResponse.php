<?php

namespace Omnipay\WorldPay\Message;

/**
 * WorldPay Authorize Request
 */
class JsonAuthorizeResponse extends JsonPurchaseResponse
{
    /**
     * @var string  Payment status that determines success
     */
    protected $successfulPaymentStatus = 'AUTHORIZED';
}
