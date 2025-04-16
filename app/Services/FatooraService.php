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
        $this->request_client = $request_client;
        $this->base_url = env('fatoora_base_url');
        $this->headers =[
            'Content-Type'=>'application/json',
             'authorization'=>'Bearer U6XIE2F4VQqjF49SPPr8h56tjVPJA39UPUxP8XyYJlGPt0LMkgastLXyg6KsO4VEbiBp-y9GBZCy1iFvDYtqpQd_l6HULTqP8kM17pFfMN85vkRfFezKJt7CuI8eLJDadJPlmLNl-gJyCt0lJK-NEpPDckp0XgOxLtkkG7gMPmv-zyR_WUni70PyM62gs6imXu0Y-SUl-MiLB-iulyaNlmdTGOSdmErCuJkxTxert7-7wnbNzBKkxIXxdsCzIYKweOcMuida3hmBLzccOJE_-ulE0gObNhSmU0AymbWjtiToa-1dYqtx3AEsAWs_B5Mf1TZhOJ3qAszAZyflBnyvN2aYC9Bau-kLFvrrEk3yeyGo32vp4i_pl3kbf6xDXI32RA25PQKi2FkWxrXFGggtfwOo19tbT62RmPeStCPiW5SYgHwFm3Ld4b24_AFUivbif-xOIklu96XxH_NP8QZ3Ts89jUiPuysIjX8QIVscRzp3mt1-X96eFjiXMR0J9C1dvvui_QEI6EETGH-4tqFpurcUfk2oeBJt7os1zL-BDT5ZuBbvSpQqpV_lVd8aT8ukDbEEqOAuTdNaDJVKn1R5JPgF72tLXMaky7QP5LIMTs_3vFQqwpdn8zuCJX9KzFhd3KhX3AENPHFOsX32vnYkRxlIhTlLHeT6GK2Da6EnEU_NpOCx'       ];
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
    
