<?php

namespace Omnipay\WorldPay\Message;

/**
 * WorldPay Purchase Request
 */
class JsonRefundRequest extends JsonAbstractRequest
{

    public function getData()
    {
        $this->validate('amount');

        $data = array();

        $data['refundAmount'] = $this->getAmountInteger();

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($data);

        return $this->response = new JsonResponse($this, $httpResponse);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint.'/orders/'.$this->getTransactionReference().'/refund';
    }
}
