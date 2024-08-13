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

    public function sendRequest($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $curl_response= curl_exec($ch);
        curl_close($ch);
        return $curl_response;
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
