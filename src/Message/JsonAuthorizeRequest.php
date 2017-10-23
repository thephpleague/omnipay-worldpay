<?php

namespace Omnipay\WorldPay\Message;

/**
 * WorldPay Purchase Request
 */
class JsonAuthorizeRequest extends JsonPurchaseRequest
{
    /**
     * Set up the authorize-specific data
     *
     * @return mixed
     */
    public function getData()
    {
        $data = parent::getData();

        $data['authorizeOnly'] = true;

        return $data;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\WorldPay\Message\JsonAuthorizeResponse';
    }
}
