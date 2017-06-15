<?php

namespace Omnipay\WorldPay\Message;

/**
 * WorldPay Capture Request
 */
class JsonCaptureRequest extends JsonAbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $data = array();

        $data['captureAmount'] = $this->getAmountInteger();

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint.'/orders/'.$this->getTransactionReference().'/capture';
    }
}
