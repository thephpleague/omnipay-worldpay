<?php

namespace Omnipay\WorldPay\Message;

/**
 * WorldPay Purchase Request
 */
class JsonAuthorizeRequest extends JsonPurchaseRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data['authorizeOnly'] = true;

        return $data;
    }
}
