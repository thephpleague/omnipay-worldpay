<?php

namespace Omnipay\WorldPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * WorldPay Purchase Request
 */
class JsonPurchaseResponse extends JsonResponse
{

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $isHttpSuccess = parent::isSuccessful();
        $isPurchaseSuccess = false;

        if (isset($this->data['paymentStatus']) && $this->data['paymentStatus'] == 'SUCCESS') {
            $isPurchaseSuccess = true;
        }

        return ($isHttpSuccess && $isPurchaseSuccess);
    }
}
