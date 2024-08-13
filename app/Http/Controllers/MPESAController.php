<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MPESAController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function generateAccessToken1()
    {
        // *** Authorization Request in PHP ***|
        $mpesaUrl = env('MPESA_ENV') == 0 ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials' : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $ch = curl_init($mpesaUrl);
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_HTTPHEADER => array('Content-Type:application/json; charset=utf8'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => env('MPESA_CONSUMER_KEY') . ':' . env('MPESA_CONSUMER_SECRET')
            )
        );
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . base64_encode(env('MPESA_CONSUMER_KEY') . ':' .env('MPESA_CONSUMER_SECRET'))]);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        // dd($response->access_token);
        return $response->access_token;
    }

    public function makeHTTP($mpesaUrl, $body)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $mpesaUrl,
                CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $this->generateAccessToken()),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POSTFIELDS => json_encode($body)
            )
        );
        $curl_response = curl_exec($curl);
        dd($curl_response);
        curl_close($curl);
        return '$curl_response';
    }

    public function sendRequest1($mpesa_url, $curl_post_data)
    {
        $ch = curl_init($mpesa_url);
        curl_setopt($ch, CURLOPT_URL, $mpesa_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->generateAccessToken1(), 'Content-Type: application/json']);
        $data_string = json_encode($curl_post_data, JSON_UNESCAPED_SLASHES);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Log::info($data_string);
        $curl_response = curl_exec($ch);
        curl_close($ch);
        return $curl_response;
    }

    public function registerURL1()
    {
        $body = array(
            'ShortCode' => env('MPESA_SHORTCODE'),
            'ResponseType' => 'Completed',
            'ConfirmationURL' => url('') . '/api/confirmation',
            'ValidationURL' => url('') . '/api/validation'
        );
        $mpesaUrl = env('MPESA_ENV') == 0 ? 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl' : 'https://api.safaricom.co.ke/mpesa/c2b/v2/registerurl';
        $response = json_decode($this->sendRequest($mpesaUrl, $body));
        return $response;
    }

    public function simulateTransaction()
    {
        $body = array(
            'Amount' => '10',
            'CommandID' => 'CustomerPayBillOnline',
            'Msisdn' => '254708374149',
            'BillRefNumber' => 'testing',
            'ShortCode' => env('MPESA_SHORTCODE'),
        );
        $mpesaUrl = env('MPESA_ENV') == 0 ? 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate' : 'https://api.safaricom.co.ke/mpesa/c2b/v1/simulate';
        $response = $this->sendRequest1($mpesaUrl, $body);
        $results = json_decode($response);
        return $results;
    }

    // live==========

    public function generateAccessToken($consumer_key, $consumer_secret)
    {
        // *** Authorization Request in PHP ***|
        $mpesaUrl = env('MPESA_ENV') == 0 ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials' : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $ch = curl_init($mpesaUrl);
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_HTTPHEADER => array('Content-Type:application/json; charset=utf8'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => $consumer_key . ':' . $consumer_secret
            )
        );
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        return $response->access_token;
    }
    public function sendRequest($mpesa_url, $curl_post_data, $consumer_key, $consumer_secret)
    {
        $ch = curl_init($mpesa_url);
        curl_setopt($ch, CURLOPT_URL, $mpesa_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->generateAccessToken($consumer_key, $consumer_secret), 'Content-Type: application/json']);
        $data_string = json_encode($curl_post_data, JSON_UNESCAPED_SLASHES);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Log::info($data_string);
        $curl_response = curl_exec($ch);
        curl_close($ch);
        Log::info($curl_response);
        return $curl_response;
    }
    public function registerUrl($data)
    {
        $body = array(
            'ShortCode' => $data['shortcode'],
            'ResponseType' => 'Completed',
            'ConfirmationURL' => url('') . '/api/c2b/confirmation',
            'ValidationURL' => url('') . '/api/c2b/validation'
        );
        Log::info($body);
        $mpesaUrl = env('MPESA_ENV') == 0 ? 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl' : 'https://api.safaricom.co.ke/mpesa/c2b/v2/registerurl';
        $response = json_decode($this->sendRequest($mpesaUrl, $body, $data['key'], $data['secret']));
        Log::info($response);
        return $response;
    }
}
