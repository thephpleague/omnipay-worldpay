<?php

namespace Omnipay\Worldpay\Message;

use Omnipay\Tests\TestCase;

class JsonRefundRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new JsonRefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array('amount'=>'5.00')
        );
        $this->request->setTransactionReference('e0bf69e8-8c98-4e01-893b-d040fa41dd9b');
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('JsonRefundResponseSuccess.txt');
        $response = $this->request->send();

        $data = $this->request->getData();

        $code = $response->response->getStatusCode();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(500, $data['refundAmount']);
        $this->assertEquals(200, $code);
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('JsonRefundResponseError.txt');
        $response = $this->request->send();

        $data = $this->request->getData();

        $code = $response->response->getStatusCode();
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(500, $data['refundAmount']);
        $this->assertEquals(400, $code);
        $this->assertSame('BAD_REQUEST', $response->getCode());
        $this->assertSame(
            'TEST Order: e0bf69e8-8c98-4e01-893b-d040fa41dd9b cannot be refunded while in status: REFUNDED - try again later.',
            $response->getMessage()
        );
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCardReference());
    }
}
