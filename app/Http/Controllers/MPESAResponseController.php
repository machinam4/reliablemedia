<?php

namespace App\Http\Controllers;

use App\Models\Players;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MPESAResponseController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function confirmation(Request $request)
    {
        // $data = json_decode($request->getContent());
        // Log::info('confirmation hit');
        $data = $request->all();
        $data["BillRefNumber"] = strtoupper($data["BillRefNumber"]);
        if ($data["TransactionType"] == "Customer Merchant Payment") {
            $data["BillRefNumber"] = $data["BusinessShortCode"];
            //  Log::info(["data", $data["BillRefNumber"], $data["BusinessShortCode"]]);
        }
        //  Log::info([$data["BillRefNumber"], $data["TransactionType"]]);

        Players::Create($data);
        //  Log::info($data);
        $response = Http::post('https://phonebook.ridhishajamii.com/api/phonebook/querytrans', $request->all());
        return "success";
    }

    public function validation(Request $request)
    {
        // Log::info('validation hit');
        // Log::info($request->all());       
        return  [
            "ResultCode" => 0,
            "ResultDesc" => "Accept Service"
        ];
    }
}
