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


    public function sendRequest($data)
    {
        // Stripe only accepts TLS >= v1.2, so make sure Curl is told
        $config = $this->httpClient->getConfig();
        $curlOptions = $config->get('curl.options');
        $curlOptions[CURLOPT_SSLVERSION] = 6;
        $config->set('curl.options', $curlOptions);
        $this->httpClient->setConfig($config);

        // don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            null,
            json_encode($data)
        );

        $httpResponse = $httpRequest
            ->setHeader('Authorization', $this->getServiceKey())
            ->setHeader('Content-type', 'application/json')
            ->send();

        return $httpResponse;
    }
}
