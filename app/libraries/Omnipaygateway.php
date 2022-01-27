<?php

use Omnipay\Omnipay;
use Omnipay\paypal;
use Omnipay\Common\CreditCard;

class Omnipaygateway extends Omnipay {
    protected $gateway = null;

    public function __construct($set_gateway='Paypal_Pro',$test_mode=true){
        $this->gateway = Omnipay::create($set_gateway);
        $this->gateway->setUsername('sb-a471nm12560615_api1.business.example.com');
        $this->gateway->setPassword('RHANZPHT86RVCQLW');
        $this->gateway->setSignature('AYZugqb0ZSS8uzeqYM9jOa84TCLyASIdIsZeJM2xCjPula6MD9YAtL1L');
        $this->gateway->setTestMode($test_mode);
    }

    public function sendPurchase($carInput, $valTransaction){
        $card = new CreditCard($cardInput1);
        $payArray = array(
            'amount'=>$valTransaction['amount'],
            'transactionId'=>$valTransaction['transactionId'],
            'description'=>$valTransaction['description'],
            'currency'=>$valTransaction['currency'],
            'clientIp'=>$valTransaction['clientIp'],
            'returnUrl'=>$valTransaction['returnUrl'],
            'card'=>$card
        );
        $response = $this->gateway->pruchase($payArray)->send();
        if($response->isSuccessful()){
            $paypalResponse = $response->getData();
        }elseif($response->isRedirect()){
            $paypalResponse = $response->getRedirectData();
        }else{
            $paypalResponse = $response->getMessage();
        }
        return $paypalResponse;
    }
}