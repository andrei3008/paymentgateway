<?php

namespace Psyro\Paymentgateway\Tests\Gateways;

use Psyro\Paymentgateway\Base\Gateways\Senangpay;
use Psyro\Paymentgateway\Base\Gateways\ZitoPay;
use Psyro\Paymentgateway\Tests\TestCase;

class SenangpayTest extends TestCase
{
    public function test_charge_amount()
    {
        $zitopay = new Senangpay();
        $zitopay->setCurrency('MYR');
        $this->assertEquals(10.00, $zitopay->charge_amount(10.00));
    }

    public function test_charge_customer()
    {
        $zitopay = new Senangpay();
        $zitopay->setMerchantId('358169193868945');
        $zitopay->setSecretKey('5876-708');
        $zitopay->setEnv(true);
        $zitopay->setHashMethod('sha256');
        $zitopay->setCurrency('MYR');
        $response = $zitopay->charge_customer([
            'amount' => 25.5,
            'title' => 'this is test title',
            'description' => 'this is test description',
            'ipn_url' => route('post.ipn'), //post route
            'order_id' => 56,
            'track' => 'asdfasdfsdf',
            'cancel_url' => route('payment.failed'),
            'success_url' => route('payment.success'),
            'email' => 'andrei3008@gmail.com',
            'name' => 'andrei',
            'payment_type' => 'order',
        ]);
        $this->assertArrayHasKey('url', $response);
    }

}
