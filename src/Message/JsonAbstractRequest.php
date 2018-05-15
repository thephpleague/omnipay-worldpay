<?php

namespace Omnipay\WorldPay\Message;

use Guzzle\Http\Message\Response as HttpResponse;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

abstract class JsonAbstractRequest extends AbstractRequest
{
    /**
     * @var string  API endpoint base to connect to
     */
    protected $endpoint = 'https://api.worldpay.com/v1';

    /**
     * Method required to override for getting the specific request endpoint
     *
     * @return string
     */
    abstract public function getEndpoint();

    /**
     * The HTTP method used to send data to the API endpoint
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * Get the stored merchant ID
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Set the stored merchant ID
     *
     * @param string $value  Merchant ID to store
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Get the stored service key
     *
     * @return string
     */
    public function getServiceKey()
    {
        return $this->getParameter('serviceKey');
    }

    /**
     * Set the stored service key
     *
     * @param string $value  Service key to store
     */
    public function setServiceKey($value)
    {
        return $this->setParameter('serviceKey', $value);
    }

    /**
     * Get the stored client key
     *
     * @return string
     */
    public function getClientKey()
    {
        return $this->getParameter('clientKey');
    }

    /**
     * Set the stored client key
     *
     * @param string $value  Client key to store
     */
    public function setClientKey($value)
    {
        return $this->setParameter('clientKey', $value);
    }

    /**
     * Make the actual request to WorldPay
     *
     * @param mixed $data  The data to encode and send to the API endpoint
     *
     * @return \Psr\Http\Message\ResponseInterface HTTP response object
     */
    public function sendRequest($data)
    {
        return $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [
                'Accept' => 'application/json',
                'Authorization' => $this->getServiceKey(),
                'Content-Type' => 'application/json',
            ],
            json_encode($data)
        );
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\WorldPay\Message\JsonResponse';
    }

    /**
     * Send the request to the API then build the response object
     *
     * @param mixed $data  The data to encode and send to the API endpoint
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
