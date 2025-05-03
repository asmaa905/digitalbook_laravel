<?php
// File: app/Services/BookService.php

namespace App\Services;
use App\Model\Tax;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Psr7\Request;

class FatooraService
{
    private $base_url;
    private $headers;
    private $request_client;
    /**
     * FatooraSevice constructor
     * @param Client $request_Client
     */
    public function __construct(Client $request_client)
    {
        $this->request_client = new Client([
            'verify' => false // Disables SSL verification
        ]);
        $this->base_url = 'https://apitest.myfatoorah.com';
        $this->headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Bearer ' . env('fatoora_api_token')
        ];
    }
    private function buildRequest($url, $method, $data = []) {
      $request = new Request($method, $this->base_url.$url, $this->headers);
      
      try {
          $response = $this->request_client->send($request, [
              'json' => $data
          ]);
          
          if ($response->getStatusCode() != 200) {
              throw new \Exception("API request failed with status: ".$response->getStatusCode());
          }
          
          return json_decode($response->getBody(), true);
      } catch (\Exception $e) {
          // Log the error for debugging
          \Log::error("MyFatoorah API Error: ".$e->getMessage());
          return false;
      }
  }
    public function sendPayment($data)
    {
       return $response = $this->buildRequest('/v2/SendPayment','POST',$data);
    }
    // private function saveTransactionPayment(Request $request){
    // }
    //     private function TransationCallBack(Request $request){
    //       return $request;    
    //   }
    public function getPaymentStatus( $data){
        return $response = $this->buildRequest('/v2/getPaymentStatus','POST', $data);
    }
}
    
