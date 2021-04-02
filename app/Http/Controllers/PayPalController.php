<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\URL;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;

class PayPalController extends Controller
{
    /**
     *
     */
    public function createPlan()
    {
        $plan = new Plan();
        $plan->setName('T-Shirt of the Month Club Plan')
        ->setDescription('Template creation.')
        ->setType('fixed');
        $paymentDefinition = new PaymentDefinition();

        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("2")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 100, 'currency' => 'USD')));

        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));

        $paymentDefinition->setChargeModels(array($chargeModel));

        $merchantPreferences = new MerchantPreferences();
        $baseUrl = URL::to('/');

        $merchantPreferences->setReturnUrl("$baseUrl/ExecuteAgreement.php?success=true")
            ->setCancelUrl("$baseUrl/ExecuteAgreement.php?success=false")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        $request = clone $plan;

        try {
            $output = $plan->create($this->apiContext);
        } catch (Exception $ex) {
            ResultPrinter::printError("Created Plan", "Plan", null, $request, $ex);
            exit(1);
        }
        ResultPrinter::printResult("Created Plan", "Plan", $output->getId(), $request, $output);
        return $output;
    }
}
