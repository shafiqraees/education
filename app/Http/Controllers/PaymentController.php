<?php

namespace App\Http\Controllers;

use App\Mail\VerifyUser;
use App\Models\Teacher;
use App\Models\Transanction;
use App\Paypal\CreatePayment;
use App\Paypal\ExecutePayment;
use Carbon\Carbon;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\RedirectUrls;
use Illuminate\Http\Request;
use App\Mail\Credentials;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $payment = new CreatePayment;
        return $payment->create($request);
    }

    public function execute()
    {
        $payment = new ExecutePayment;
        $payment =  $payment->execute();
        //dd($payment->transactions[0]->amount);
        if ($payment) {
            $trancsaction_data = [
                'transaction_id' => $payment->id,
                'state' => $payment->payer->state,
                'status' => $payment->payer->payer_info->payer_id,
                'payer_id' => $payment->payer->payer_info->payer_id,
                'invoice_number' => $payment->payer->payer_info->payer_id,
                'package_name' => "Basic Plan",
                'name' =>  $payment->payer->payer_info->first_name . " ".$payment->payer->payer_info->last_name,
                'email' => $payment->payer->payer_info->email,
                'amount' => 72,
            ];
            Transanction::create($trancsaction_data);
            $teacher = Teacher::whereEmail($payment->payer->payer_info->email)->first();
            if ($teacher) {
                return redirect()->route('teacher.login')->with('success','package successfully purchased');
            } else {
                $details = [
                    'title' => 'Account Credentials',
                    'body' => $payment->payer->payer_info->email,
                    'link' => "12345678"
                ];
                Mail::to($payment->payer->payer_info->email)->send(new Credentials($details));

                $data = [
                    'name' => $payment->payer->payer_info->first_name,
                    'email' => $payment->payer->payer_info->email,
                    'password' => Hash::make(12345678),
                    'org_password' => '12345678',
                    'profile_photo_path' => "defalut",
                    'email_verified_at' => Carbon::now(),
                ];
                Teacher::create($data);
            }
            return redirect()->route('teacher.login')->with('success','package successfully purchased');
            }
    }
}
