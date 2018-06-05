<?php

namespace App\Http\Controllers;

use App\Helpers\safaricom\Mpesa;
use App\TransactionLog;
use App\Log;
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

    public function c2bValidate()
    {
         $resultArray = [
             'ResultCode' => '0',
             'ResultMsg' => 'Service Processing successful' 
         ];
        header('Content-Type: application\json');
        return response()->json($resultArray);
          

    }

    public function SimulateTransactionResponse(Request $request)
    {
      $request->headers->set('content-type', 'application/json');

      $transaction = $request->getContent();
        Log::create(['description' => 'IPN', 'content' => $transaction]);
//        exit;
        
//        print_r($transaction);exit;
        $transaction_strip = json_decode($transaction, true);
        
//        print_r($transaction_strip);exit;

      $transId = $transaction_strip["TransID"];
      $transTime = $transaction_strip["TransTime"];
      $transAmount = $transaction_strip["TransAmount"];
      $businessShortCode = $transaction_strip["BusinessShortCode"];
      $billRefNumber = $transaction_strip["BillRefNumber"];
      $invoiceNumber = $transaction_strip["InvoiceNumber"];
      $accountBalance = $transaction_strip["OrgAccountBalance"];
      $thirdPartyTrans = $transaction_strip["ThirdPartyTransID"];
      $msisdn = $transaction_strip["MSISDN"];
      $firstName = $transaction_strip["FirstName"];
      $middleName = $transaction_strip["MiddleName"];
      $lastName = $transaction_strip["LastName"];


//        $userTransaction = UserTransaction::all();

      UserTransaction::create([
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
    
//    public function decDb()
//    {
//
//        $log = Log::get();
//        
//        $transaction = json_decode($log);
//        
//        return response()->json($transaction);
//        
//        
//    }

}
