<?php

namespace Omnipay\Worldpay\Message;

use Omnipay\Tests\TestCase;

class JsonAuthorizeRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new JsonAuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => '12.00',
                'currency' => 'USD',
                'token' => 'TEST_RU_7a22d2ec-6725-48b7-b8e7-243f03914b27',
                'description' => 'Order #4',
                'card' => array(
                    'name' => "Luke Holder",
                    'address1' => '123 Somewhere St',
                    'address2' => 'Suburbia',
                    'city' => 'Little Town',
                    'postcode' => '1234',
                    'state' => 'CA',
                    'country' => 'US',
                    'phone' => '1-234-567-8900'
                )
           )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame(1200, $data['amount']);
        $this->assertSame('USD', $data['currency']);
        $this->assertSame('Order #4', $data['orderDescription']);
    }

    public function testDataWithToken()
    {
        $this->request->setToken('xyz');
        $data = $this->request->getData();

        $this->assertSame('xyz', $data['token']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('JsonAuthorizeResponseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('e0bf69e8-8c98-4e01-893b-d040fa41dd9b', $response->getTransactionReference());
        $this->assertSame('TEST_RU_7a22d2ec-6725-48b7-b8e7-243f03914b27', $response->getCardReference());
        $this->assertEquals('AUTHORIZED', $response->getMessage());
    }
}
