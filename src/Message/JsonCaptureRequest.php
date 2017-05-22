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
     * @param mixed $data
     *
     * @return JsonResponse
     */
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
        return $this->endpoint.'/orders/'.$this->getTransactionReference().'/capture';
    }
}
