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
             'authorization'=>'Bearer AsTYfKprDDtGNNlhy1T6LV85yZtK4VrGjcKu6KMkOjudglh9fkY4R_xbnFoOweMlmzwk84QaJaxtX2eUXVbgVaBLIUKORnNRKJpBlG-qee9cZQQMesVetN9mMhsS23RjxjBK5__BJxI8QE9Mf3lxFlnkwq3DOaltFJ9GmT4D3NLsa5t0t3w21s9NEaIdxiF7QI_ZgvqW9tbr1j2bUyjgz1JAKgFkOQPFZrOW7Fkqh6aVIfGyVqwd5eI6ysBa3wtrttCy0-VGEUu42QQTKWUJPA3HsgEu-XxDR_4ZTHE4Y1xPjOF9QC4wNvu0CF8UsO9xUlX6Gek-xzyrOp4ssAHYPnim-M3y2jhLfsKylR6DWdhd328l2a9Rt_omMCN-MRHbGdzdvGFKG2X0te6CVPOyWtujH5B9vqHhNrxQ_vtphTs9rjCMMo69xSDcaysCDIQfzJt5Y0Kk1DOlN-UHBSGt5Y56m7VdFD9koXoN5FZqCHhS_0jaq25nvg62pvOFYlvUTHuDnS161jrWPOo8TtWuCtjvL68j9vu6VgktmI2ZQ7w7o8D4n4yvAlk9f2gX7n3eIMAHJB-p1DgmseTEpyYX5pK6EJDcg66th8CSQJcI3LRuxcqqVQZ8tPdgJHXK0rr9fHgGVUMyrb1o0Uhh30C7X3HylLYkKbb6lphTdAvuXFANrMgj'       ];
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
    
