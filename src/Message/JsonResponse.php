<?php

namespace Omnipay\WorldPay\Message;

use Guzzle\Http\Message\Response as HttpResponse;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * WorldPay Purchase Request
 */
class JsonResponse extends AbstractResponse
{
    /**
     * @var HttpResponse  HTTP response object
     */
    public $response;

    /**
     * Constructor
     *
     * @param RequestInterface $request   The initiating request
     * @param HttpResponse     $response  HTTP response object
     */
    public function __construct(RequestInterface $request, $response)
    {
        $this->response = $response;
        parent::__construct($request, json_decode($response->getBody(), true));
    }

    /**
     * Is the response successful?
     *
     * Based on HTTP status code, as some requests have an empty body (no data) but are still a success.
     * For example see tests/Mock/JsonRefundResponseSuccess.txt
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $code = $this->response->getStatusCode();
        return $code == 200;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        if (!$this->isSuccessful() && isset($this->data['message'])) {
            return $this->data['message'];
        }
    }

    /**
     * @return string|null
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
