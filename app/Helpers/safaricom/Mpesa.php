<?php

namespace App\Helpers\safaricom;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use anlutro\LaravelSettings\Facade as Settings;
// use Illuminate\Support\Facades\Log;

Class Mpesa
{
    public static  function get($endpoint)
    {
      $client = new Client();
      $baseUrl = env('SAFARICOM_BASE_URL');
      $token = Settings::get('mpesa-api.token');

      try {
          $response = $client->get($baseUrl.$endpoint, [
              'headers' => [
                  'Authorization' => 'Bearer '.$token,
                  'Content-Type' => 'application/json',
              ]
          ]);

          return json_decode((string) $response->getBody(), true);
      } catch(BadResponseException $exception)
      {
        return json_decode((string) $exception->getResponse()->getBody()->getContents(), true);
      }
    }

    public static function post($endpoint, $requestBody)
    {
      $client = new Client();
      $baseUrl = env('SAFARICOM_BASE_URL');
      $token = Settings::get('mpesa-api.token');
      // Log::info($token);

      try {
        $response = $client->post($baseUrl.$endpoint, [
          'headers' => [
              'Authorization' => 'Bearer '.$token,
              'Content-Type' => 'application/json',
          ],
          'json' => $requestBody
        ]);

        return json_decode((string) $response->getBody(), true);
      } catch(BadResponseException $exception)
      {
        return json_decode((string) $exception->getResponse()->getBody()->getContents(), true);
      }
    }

    public static function generateToken()
    {
      $client = new Client();
      $baseUrl = env('SAFARICOM_BASE_URL');
      $credentials = base64_encode(env('SAFARICOM_KEY').':'.env('SAFARICOM_SECRET'));

      try {
        $response = $client->get($baseUrl.'oauth/v1/generate?grant_type=client_credentials',[
          'headers' => [
              'Authorization' => 'Basic '.$credentials,
              'Content-Type' => 'application/json',
          ]
        ]);

        return json_decode((string) $response->getBody(), true);
      } catch(BadResponseException $exception)
      {
        return json_decode((string) $exception->getResponse()->getBody()->getContents(), true);
      }
    }
}
