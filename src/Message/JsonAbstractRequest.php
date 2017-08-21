<?php

namespace Omnipay\WorldPay\Message;

use Omnipay\Common\Message\AbstractRequest;

abstract class JsonAbstractRequest extends AbstractRequest
{
    protected $endpoint = 'https://api.worldpay.com/v1';

    public function getHttpMethod()
    {
        return 'POST';
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getServiceKey()
    {
        return $this->getParameter('serviceKey');
    }

    public function setServiceKey($value)
    {
        return $this->setParameter('serviceKey', $value);
    }

    public function getClientKey()
    {
        return $this->getParameter('clientKey');
    }

    public function setClientKey($value)
    {
        return $this->setParameter('clientKey', $value);
    }

    /**
     * Method required to override for getting the specific request endpoint
     *
     * @return string
     */
    abstract public function getEndpoint();

    public function sendRequest($data)
    {
        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [],
            json_encode($data)
        );

        $httpRequest = $httpRequest
            ->withHeader('Authorization', $this->getServiceKey())
            ->withHeader('Content-type', 'application/json');

        $httpResponse = $this->httpClient->sendRequest($httpRequest);

        return $httpResponse;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\WorldPay\Message\JsonResponse';
    }

    /**
     * @param mixed $data
     *
     * @return JsonResponse
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($data);

        $responseClass = $this->getResponseClassName();
        return $this->response = new $responseClass($this, $httpResponse);
    }
}
