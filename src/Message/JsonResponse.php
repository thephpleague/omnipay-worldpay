<?php

namespace Omnipay\WorldPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * WorldPay Purchase Request
 */
class JsonResponse extends AbstractResponse
{
    public $response;

    /**
     * Constructor
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $response
     */
    public function __construct(RequestInterface $request, $response)
    {
        $this->response = $response;
        parent::__construct($request, json_decode($response->getBody(), true));
    }

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        // Some requests have an empty body (no data) but are still a success.
        // For example see tests/Mock/JsonRefundReponseSuccess.txt

        $code = $this->response->getStatusCode();
        return $code == 200;
    }

    /**
     * @return bool|null
     */
    public function getMessage()
    {
        if (!$this->isSuccessful()) {
            return $this->data['message'];
        }

        if (isset($this->data['paymentStatus'])) {
            return $this->data['paymentStatus'];
        }
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        if (isset($this->data['customCode'])) {
            return $this->data['customCode'];
        }
    }

    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        if (isset($this->data['orderCode'])) {
            return $this->data['orderCode'];
        }
    }

    /**
     * @return string|null
     */
    public function getCardReference()
    {
        if (isset($this->data['token'])) {
            return $this->data['token'];
        }
    }
}
