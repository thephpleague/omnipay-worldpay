<?php

namespace Omnipay\WorldPay;

use Omnipay\Common\AbstractGateway;

/**
 * WorldPay Gateway
 *
 * @link https://developer.worldpay.com/jsonapi/docs
 */
class JsonGateway extends AbstractGateway
{
    /**
     * Name of the gateway
     *
     * @return string
     */
    public function getName()
    {
        return 'WorldPay JSON';
    }

    /**
     * Setup the default parameters
     *
     * @return string[]
     */
    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'serviceKey' => '',
            'clientKey' => '',
        );
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
     * Create purchase request
     *
     * @param array $parameters
     *
     * @return \Omnipay\WorldPay\Message\JsonPurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPay\Message\JsonPurchaseRequest', $parameters);
    }

    /**
     * Create authorize request
     *
     * @param array $parameters
     *
     * @return \Omnipay\WorldPay\Message\JsonAuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPay\Message\JsonAuthorizeRequest', $parameters);
    }

    /**
     * Create refund request
     *
     * @param array $parameters
     *
     * @return \Omnipay\WorldPay\Message\JsonRefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPay\Message\JsonRefundRequest', $parameters);
    }

    /**
     * Create capture request
     *
     * @param array $parameters
     *
     * @return \Omnipay\WorldPay\Message\JsonCaptureRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPay\Message\JsonCaptureRequest', $parameters);
    }
}
