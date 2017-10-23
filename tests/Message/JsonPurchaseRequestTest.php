<?php

namespace Omnipay\Worldpay\Message;

use Omnipay\Tests\TestCase;

class JsonPurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new JsonPurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => '5.00',
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

        $this->assertSame(500, $data['amount']);
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
        $this->setMockHttpResponse('JsonPurchaseResponseSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('e0bf69e8-8c98-4e01-893b-d040fa41dd9b', $response->getTransactionReference());
        $this->assertSame('TEST_RU_7a22d2ec-6725-48b7-b8e7-243f03914b27', $response->getCardReference());
        $this->assertSame('SUCCESS', $response->getMessage());
        $this->assertSame('\Omnipay\WorldPay\Message\JsonPurchaseResponse', $this->request->getResponseClassName());
        $this->assertSame('Omnipay\WorldPay\Message\JsonPurchaseResponse', get_class($response));
    }

    /**
     * Simulate card declined (no error in transit, 200 HTTP response)
     */
    public function testSendFailure()
    {
        $this->setMockHttpResponse('JsonPurchaseResponseFailure.txt');
        $response = $this->request->send();

        $data = $this->request->getData();

        $code = $response->response->getStatusCode();
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(500, $data['amount']);
        $this->assertEquals(200, $code);
        $this->assertNull($response->getCode());
        $this->assertSame("REFUSED", $response->getMessage());
        $this->assertSame('e0bf69e8-8c98-4e01-893b-d040fa41dd9b', $response->getTransactionReference());
        $this->assertSame('TEST_RU_7a22d2ec-6725-48b7-b8e7-243f03914b27', $response->getCardReference());
    }

    /**
     * Simulate bad request (HTTP 400 or similar)
     */
    public function testSendError()
    {
        $this->setMockHttpResponse('JsonPurchaseResponseError.txt');
        $response = $this->request->send();

        $data = $this->request->getData();

        $code = $response->response->getStatusCode();
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(500, $data['amount']);
        $this->assertEquals(400, $code);
        $this->assertSame('BAD_REQUEST', $response->getCode());
        $this->assertSame("This card is not accepted for Test transactions", $response->getMessage());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCardReference());
    }

    /**
     * Simulate malformed response body (partial success conditions)
     */
    public function testSendMalformed()
    {
        $this->setMockHttpResponse('JsonPurchaseResponseMalformed.txt');
        $response = $this->request->send();

        $code = $response->response->getStatusCode();
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(400, $code);
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCardReference());
    }

}
