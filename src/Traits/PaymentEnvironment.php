<?php

namespace Psyro\Paymentgateway\Traits;

trait PaymentEnvironment
{

    /* true === 'sandbox', false = 'production|live'*/

    protected $env;
    /* set environment : true or false */
    public function setEnv($env){
        $this->env = $env;
        return $this;
    }
    /* get environment: true or false */
    private function getEnv(){
        return $this->env;
    }
}
