<?php

namespace App\Http\Controllers;

use App\Helpers\safaricom\Mpesa;
use App\TransactionLog;
use App\UserTransaction;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

class MpesaTransactionsController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
      $this->client = $client;
    }

    public function Register(Request $request)
    {
        $shortCode = env('SAFARICOM_PAYBILL');
        $callbackUrl = env('SAFARICOM_CALLBACK_URL');
        $confirmation = env('SAFARICOM_CONFIRMATION_URL');
        $validation = env('SAFARICOM_VALIDATION_URL');

        $requestBody = [
          "ShortCode" => $shortCode,
          "ResponseType"=> "completed",
          "ConfirmationURL" =>  $confirmation,
          "ValidationURL" =>  $validation
      ];

      $response = Mpesa::post('mpesa/c2b/v1/registerurl', $requestBody); //

      return response()->json($response);
    }

    public function SimulateTransaction(Request $request)
    {
        $shortCode = env('SAFARICOM_PAYBILL');


        $requestBody = [
          "ShortCode" => $shortCode,
          "CommandID" => "CustomerPayBillOnline",
          "Amount" => $request->get('amount'),
          "Msisdn" => $request->get('phone'),
          "BillRefNumber" => $request->get('phone')
        ];

        $response = Mpesa::post('mpesa/c2b/v1/simulate', $requestBody);

        return response()->json($response);
    }

    public function SimulateTransactionResponse(Request $request)
    {
      $request->headers->set('content-type', 'application/json');

      $transaction = $request->all();


      $transId = $transaction["TransID"];
      $transTime = $transaction["TransTime"];
      $transAmount = $transaction["TransAmount"];
      $businessShortCode = $transaction["BusinessShortCode"];
      $billRefNumber = $transaction["BillRefNumber"];
      $invoiceNumber = $transaction["InvoiceNumber"];
      $accountBalance = $transaction["OrgAccountBalance"];
      $thirdPartyTrans = $transaction["ThirdPartyTransID"];
      $msisdn = $transaction["MSISDN"];
      $firstName = $transaction["FirstName"];
      $middleName = $transaction["MiddleName"];
      $lastName = $transaction["LastName"];


      $userTransaction->create([
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'account_number' => $billRefNumber,
            'amount' => $transAmount,
            'business_short_code' => $businessShortCode,
            'invoice_no' => $invoiceNumber,
            'account_balance' => $accountBalance,
            'third_party_id' => $thirdPartyTrans,
            'msisdn' => $msisdn,
            'transaction_id' => $transId,
            'transaction_time' => Carbon::parse($transTime)->toDateTimeString()
      ]);

      return response()->json($request->all());

    }

}
