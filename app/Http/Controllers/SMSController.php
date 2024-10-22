<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // bulk.ke sms sending
    public function sendSMS($message, $phone)
    {
        $curl = curl_init();

        // Prepare the data as an associative array
        $data = [
            'mobile' => $phone,
            'response_type' => 'json',
            'sender_name' => 'ReliableLtd',
            'service_id' => 0,
            'message' => $message,
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.bulk.ke/sms/sendsms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),  // Encode the array to JSON
            CURLOPT_HTTPHEADER => [
                'h_api_key: 3f191452728a9f81bef36a96f0a911afe0f8a83130be0299058882ae1b7ba260',
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            // Log the error message
            echo 'Error:'.curl_error($curl);
            // Log::error('Error:'.curl_error($curl));
        }

        curl_close($curl);
        // Log::info($response);

        // Return the response
        return $response;
    }
    
    public function getSMS()
    {
        $from_date = date('Y-m-d', strtotime('-30 days'));
        $to_date=date('Y-m-d');
        $start=0;
        $length=100;
        $response=$this->sendRequest('https://userapi.helomobile.co.ke/api/v2/GetSMS?ApiKey=TDQD9hNoy8MXmjzDG%2FCgVN8zPHXsZ4NN0sUOwKrdUs4%3D&ClientId=3c2553be-268d-4b2d-aa06-acc06d673631&start='.$start.'&length='.$length.'&fromdate='.$from_date.'&enddate='.$to_date);
        return $response;
    }

    public function creditBalance()
    {
        $response=$this->sendRequest('https://userapi.helomobile.co.ke/api/v2/Balance?ApiKey=TDQD9hNoy8MXmjzDG/CgVN8zPHXsZ4NN0sUOwKrdUs4=&ClientId=3c2553be-268d-4b2d-aa06-acc06d673631');
        return $response;
    }
    public function senderId()
    {
        $response=$this->sendRequest('https://userapi.helomobile.co.ke/api/v2/SenderId?ApiKey=TDQD9hNoy8MXmjzDG/CgVN8zPHXsZ4NN0sUOwKrdUs4=&ClientId=3c2553be-268d-4b2d-aa06-acc06d673631');
        return $response;
    }

    public function smsStats()
    {
        $response=[
            'credit' => $this->creditBalance(),
            'sender' => $this->senderId(),
        ];
        return json_encode($response);
    }
    
}
