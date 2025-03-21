<?php

namespace Psyro\Paymentgateway\Base;

use Psyro\Paymentgateway\Base\Gateways\AuthorizeDotNetPay;
use Psyro\Paymentgateway\Base\Gateways\BillPlzPay;
use Psyro\Paymentgateway\Base\Gateways\CashFreePay;
use Psyro\Paymentgateway\Base\Gateways\CinetPay;
use Psyro\Paymentgateway\Base\Gateways\FlutterwavePay;
use Psyro\Paymentgateway\Base\Gateways\InstamojoPay;
use Psyro\Paymentgateway\Base\Gateways\Iyzipay;
use Psyro\Paymentgateway\Base\Gateways\KineticPay;
use Psyro\Paymentgateway\Base\Gateways\MidtransPay;
use Psyro\Paymentgateway\Base\Gateways\MolliePay;
use Psyro\Paymentgateway\Base\Gateways\PagaliPay;
use Psyro\Paymentgateway\Base\Gateways\PayFastPay;
use Psyro\Paymentgateway\Base\Gateways\PaymobPay;
use Psyro\Paymentgateway\Base\Gateways\PaypalPay;
use Psyro\Paymentgateway\Base\Gateways\PaystackPay;
use Psyro\Paymentgateway\Base\Gateways\PayTabsPay;
use Psyro\Paymentgateway\Base\Gateways\PaytmPay;
use Psyro\Paymentgateway\Base\Gateways\PayUmoneyPay;
use Psyro\Paymentgateway\Base\Gateways\RazorPay;
use Psyro\Paymentgateway\Base\Gateways\SaltPay;
use Psyro\Paymentgateway\Base\Gateways\Senangpay;
use Psyro\Paymentgateway\Base\Gateways\SitesWayPay;
use Psyro\Paymentgateway\Base\Gateways\SquarePay;
use Psyro\Paymentgateway\Base\Gateways\StripePay;
use Psyro\Paymentgateway\Base\Gateways\MercadoPagoPay;
use Psyro\Paymentgateway\Base\Gateways\Toyyibpay;
use Psyro\Paymentgateway\Base\Gateways\TransactionCloudPay;
use Psyro\Paymentgateway\Base\Gateways\WiPay;
use Psyro\Paymentgateway\Base\Gateways\ZitoPay;

/**
 * @see SquarePay
 * @method  setApplicationId();
 * @method  setAccessToken();
 * @method  setLocationId();
 */

class PaymentGatewayHelpers
{

    public function stripe() : StripePay
    {
        return new StripePay();
    }
    public function paypal() : PaypalPay
    {
        return new PaypalPay();
    }
    public function midtrans() : MidtransPay
    {
        return new MidtransPay();
    }
    public function paytm() : PaytmPay
    {
        return new PaytmPay();
    }
    public function razorpay() : RazorPay
    {
        return new RazorPay();
    }
    public function mollie() : MolliePay
    {
        return new MolliePay();
    }
    public function flutterwave() : FlutterwavePay
    {
        return new FlutterwavePay();
    }
    public function paystack() : PaystackPay
    {
        return new PaystackPay();
    }

    public function payfast() : PayFastPay
    {
        return new PayFastPay();
    }
    public function cashfree() : CashFreePay
    {
        return new CashFreePay();
    }
    public function instamojo() : InstamojoPay
    {
        return new InstamojoPay();
    }
    // deprecated
    public function mercadopago() : MercadoPagoPay
    {
        return new MercadoPagoPay();
    }
    public function payumoney() : PayUmoneyPay
    {
        return new PayUmoneyPay();
    }
    public function squareup() : SquarePay
    {
        return new SquarePay();
    }
    public function cinetpay() : CinetPay
    {
        return new CinetPay();
    }
    public function paytabs() : PayTabsPay
    {
        return new PayTabsPay();
    }
    public function billplz() : BillPlzPay
    {
        return new BillPlzPay();
    }

    public function zitopay() : ZitoPay
    {
        return new ZitoPay();
    }
    public function toyyibpay() : Toyyibpay
    {
        return new Toyyibpay();
    }
    public function pagalipay() : PagaliPay
    {
        return new PagaliPay();
    }
    public function authorizenet() : AuthorizeDotNetPay
    {
        return new AuthorizeDotNetPay();
    }
    public function sitesway() : SitesWayPay
    {
        return new SitesWayPay();
    }
    public function wipay() : WiPay
    {
        return new WiPay();
    }
    public function kineticpay() : KineticPay
    {
        return new KineticPay();
    }
    public function transactionclud() : TransactionCloudPay
    {
        return new TransactionCloudPay();
    }

    public function senangpay() : Senangpay
    {
        return new Senangpay();
    }
    public function saltpay() : SaltPay
    {
        return new SaltPay();
    }

    public function paymob() : PaymobPay
    {
        return new PaymobPay();
    }

    public function iyzipay() : Iyzipay
    {
        return new Iyzipay();
    }

    public function all_payment_gateway_list() : array
    {
        return [
            'zitopay','billplz','paytabs','cinetpay','squareup',
            'mercadopago','instamojo','cashfree','payfast',
            'paystack','flutterwave','mollie','razopay','paytm',
            'midtrans','paypal','stripe','toyyibpay','pagali','authorizenet',
            'sitesway','transactionclud','wipay','kineticpay','senangpay','saltpay','paymob',
            'iyzipay'
//            'payumoney',
        ];
    }
    public function script_currency_list(){
        return GlobalCurrency::script_currency_list();
    }

    public static function wrapped_id($id) : string
    {
        return random_int(11111,99999).$id.random_int(11111,99999);
    }
    public static function unwrapped_id($id) : string
    {
        return substr($id,5,-5);
    }
    public static function get_current_file_url($Protocol='http://') {
        return $Protocol.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(__DIR__));
    }
}
