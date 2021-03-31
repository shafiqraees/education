<?php
/**
 * Created by PhpStorm.
 * User: sarthak
 * Date: 02/11/18
 * Time: 8:33 PM
 */

namespace App\Paypal;


use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use Illuminate\Http\Request;

class CreatePayment extends Paypal
{

    public function create($request)
    {

        $item1 = new Item();
        $item1->setName($request->name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->amount);
        $itemList = new ItemList();
        $itemList->setItems([$item1]);

        $payment = $this->Payment($itemList);
        $payment->create($this->apiContext);
        return redirect($payment->getApprovalLink());
    }

    /**
     * @return Payer
     */
    protected function Payer(): Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        return $payer;
    }

    /**
     * @param $itemList
     * @return Transaction
     */
    protected function Transaction( $itemList): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->Amount())
            ->setItemList($itemList)
            ->setDescription('Payment description')
            ->setInvoiceNumber(uniqid());
        return $transaction;
    }

    /**
     * @return RedirectUrls
     */
    protected function RedirectUrls(): RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(config('services.paypal.url.redirect'))
            ->setCancelUrl(config('services.paypal.url.cancel'));
        return $redirectUrls;
    }

    /**
     * @param $itemList
     * @return Payment
     */
    protected function Payment($itemList): Payment
    {
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($this->payer())
            ->setRedirectUrls($this->RedirectUrls())
            ->setTransactions([$this->transaction($itemList)]);
        return $payment;
    }
}
