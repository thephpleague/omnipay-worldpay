<?php

namespace Omnipay\WorldPay;

use Omnipay\Common\AbstractGateway;

/**
 * WorldPay Gateway
 *
 * @link http://www.worldpay.com/support/kb/bg/htmlredirect/rhtml.html
 */
class JsonGateway extends AbstractGateway
{
    public function getName()
    {
        return 'WorldPay JSON';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'serviceKey' => '',
            'clientKey' => '',
        );
    }

    public function getServiceKey()
    {
        return $this->getParameter('serviceKey');
    }

    public function setServiceKey($value)
    {
        return $this->setParameter('serviceKey', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getClientKey()
    {
        return $this->getParameter('clientKey');
    }

    public function setClientKey($value)
    {
        return $this->setParameter('clientKey', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPay\Message\JsonPurchaseRequest', $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPay\Message\JsonAuthorizeRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPay\Message\JsonRefundRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPay\Message\JsonCaptureRequest', $parameters);
    }
}
