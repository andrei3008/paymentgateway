<?php

namespace Psyro\Paymentgateway\Base\Gateways;

use Billplz\Laravel\Billplz;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Psyro\Paymentgateway\Base\PaymentGatewayBase;
use Psyro\Paymentgateway\Base\PaymentGatewayHelpers;
use Psyro\Paymentgateway\Traits\CurrencySupport;
use Psyro\Paymentgateway\Traits\MyanmarCurrencySupport;
use Psyro\Paymentgateway\Traits\PaymentEnvironment;
use Billplz\Signature;
use Illuminate\Support\Str;

class Toyyibpay extends PaymentGatewayBase
{
    use CurrencySupport,MyanmarCurrencySupport,PaymentEnvironment;
    public $userSecretKey;
    public $categoryCode;


    public function getUserSecretKey(){
        return $this->userSecretKey;
    }
    public function setUserSecretKey($userSecretKey){
        $this->userSecretKey = $userSecretKey;
        return $this;
    }

    public function getCategoryCode(){
        return $this->categoryCode;
    }
    public function setCategoryCode($categoryCode){
        $this->categoryCode = $categoryCode;
        return $this;
    }

    public function charge_amount($amount)
    {
        if (in_array($this->getCurrency(), $this->supported_currency_list())){
            return $amount * 100;
        }
        return $this->get_amount_in_myr($amount);
    }

    public function ipn_response(array $args = [])
    {

        $some_data = [
            'billCode' => request()->billcode,
            'billpaymentStatus' => '1'
        ];

        //todo:: write code for verify payment
        $response = Http::asForm()->post($this->getBaseUrl().'/getBillTransactions',$some_data);
        if ($response->ok()) {
            if(!empty($response->json())){
                return $this->verified_data([
                    'status' => 'complete',
                    'order_id' => substr( request()->order_id,5,-5),
                    'payment_amount' => request()->amount,
                    'transaction_id' => request()->billcode ,
                ]);
            }
            else{
                return ['status' => 'failed','order_id' => substr( request()->SettlementReferenceNo,5,-5)];
            }
        }
        return ['status' => 'failed','order_id' => substr( request()->SettlementReferenceNo,5,-5)];
    }

    /**
     * @throws \Exception
     */
    public function charge_customer(array $args)
    {
        $order_id =  PaymentGatewayHelpers::wrapped_id($args['order_id']);
        $some_data = array(
            'userSecretKey'=> $this->getUserSecretKey(),
            'categoryCode'=> $this->getCategoryCode(),
            'billName'=> Str::limit($args['dtitleescription'],25),
            'billDescription'=> Str::limit($args['description'],90),
            'billPriceSetting'=>1,
            'billPayorInfo'=>1,
            'billAmount'=> $this->charge_amount($args['amount']),  //100=1myr or 1RM
            'billReturnUrl'=> $args['success_url'], //return get url
            'billCallbackUrl'=> $args['ipn_url'], //webhook post url
            'billExternalReferenceNo' =>  $order_id, //order_id
            'billTo'=> $args['name'],
            'billEmail'=> $args['email'],
            'billPhone'=> $args['mobile'] ?? '123456789',
            'billSplitPayment'=>0,
            //'billSplitPaymentArgs'=>'',
            'billPaymentChannel'=>'2',
            //'billContentEmail'=>'Thank you for purchasing our product!',
            'billChargeToCustomer'=>1,
            'billExpiryDate'=> Carbon::now()->addDays(5)->format('d-m-Y h:i:s'),//'17-12-2020 17:00:00',
            'billExpiryDays'=>5
        );

        $response = Http::asForm()->post($this->getBaseUrl().'/createBill',$some_data);

        $result = $response->object();
        if ($response->ok() && !is_null($result)) {

            if (!is_array($result) && property_exists($result,'status') && $result->status === 'error'){
                abort(422,$result->msg);
            }

            $billCode = current($result)->BillCode;
            $redirect_url = $this->getBaseUrl(false) . $billCode;
            return redirect()->away($redirect_url);
        }

        abort(422,__('Toyyibpay authorization failed'));
    }

    public function supported_currency_list()
    {
        return  ['MYR'];
    }

    public function charge_currency()
    {
        return 'MYR';
    }

    public function gateway_name()
    {
        return 'toyyibpay';
    }

    private function getBaseUrl($api = true){
        $sandbox_prefix = $this->getEnv() ? 'dev.' : "";//sandbox
        $api_slug = $api ? 'index.php/api' : '';
        return 'https://'.$sandbox_prefix.'toyyibpay.com/'.$api_slug;
    }
}
