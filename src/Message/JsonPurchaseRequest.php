<?php

namespace Omnipay\WorldPay\Message;

/**
 * WorldPay Purchase Request
 */
class JsonPurchaseRequest extends JsonAbstractRequest
{
    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('amount', 'token');

        $data = array();
        $data['token'] = $this->getToken();
        $data['amount'] = $this->getAmountInteger();
        $data['currencyCode'] = $this->getCurrency();
        $data['orderDescription'] = $this->getDescription();
        $data['customerOrderCode'] = $this->getTransactionId();
        $data['currency'] = $this->getCurrency();

        $card = $this->getCard();

        $data['billingAddress'] = array();

        if ($card) {
            $data['billingAddress']['address1'] = $card->getBillingAddress1();
            $data['billingAddress']['address2'] = $card->getBillingAddress2();
            $data['billingAddress']['city'] = $card->getBillingCity();
            $data['billingAddress']['state'] = $card->getBillingState();
            $data['billingAddress']['countryCode'] = $card->getBillingCountry();
            $data['billingAddress']['postalCode'] = $card->getBillingPostcode();
            $data['billingAddress']['telephoneNumber'] = $card->getBillingPhone();

            $data['name'] = $card->getName();

            $data['deliveryAddress'] = array();

            $data['deliveryAddress']['firstName'] = $card->getShippingFirstName();
            $data['deliveryAddress']['lastName'] = $card->getShippingLastName();
            $data['deliveryAddress']['address1'] = $card->getShippingAddress1();
            $data['deliveryAddress']['address2'] = $card->getShippingAddress2();
            $data['deliveryAddress']['city'] = $card->getShippingCity();
            $data['deliveryAddress']['state'] = $card->getShippingState();
            $data['deliveryAddress']['countryCode'] = $card->getShippingCountry();
            $data['deliveryAddress']['postalCode'] = $card->getShippingPostcode();
            $data['deliveryAddress']['telephoneNumber'] = $card->getBillingPhone();

            $data['shopperEmailAddress'] = $card->getEmail();

        }

        $data['shopperIpAddress'] = $this->getClientIp();

        // Omnipay does not support recurring at the moment
        $data['orderType'] = 'ECOM';

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint.'/orders';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\WorldPay\Message\JsonPurchaseResponse';
    }
}
