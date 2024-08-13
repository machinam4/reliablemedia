<?php

namespace App\Http\Controllers;

use App\Models\mpesa;
use App\Models\Radio;
use App\Models\Players;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MPESAController;
use Carbon\Carbon;

class PlayersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cors');
    }
    public function players()
    {
        //if user is admin return all data 

        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Developer') {
            $players = Players::whereDate('TransTime', date('Y-m-d'))->get();
        } else {
            $role = Auth::user()->role;
            $radio = Radio::where('name', $role)->first();
            $store = explode('@', $radio['store']);
            $shortcode = end($store);
            $RefNumber = $radio['shortcode'];
            if ($RefNumber == 'NONE') {
                $players = Players::whereDate('TransTime', date('Y-m-d'))->where("BusinessShortCode", $shortcode)->get();
            } else {
                $players = Players::whereDate('TransTime', date('Y-m-d'))->where("BusinessShortCode", $shortcode)->where('BillRefNumber', 'LIKE', '%' . $RefNumber . '%')->get();
            }
        }
        $radios = Radio::all();
        $totalPlayers = $players->count();
        $totalAmount = $players->sum('TransAmount');
        return view('admin.players', ['players' => $players, 'totalplayers' => $totalPlayers, 'totalAmount' => $totalAmount, 'radios' => $radios]);
    }

    public function online($index)
    {
        //if user is admin return all data
        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Developer') {
            $players = Players::whereDate('TransTime', date('Y-m-d'));
            // if user is radio station, return specific data
        } else {
            $role = Auth::user()->role;
            $radio = Radio::where('name', $role)->first();
            $store = explode('@', $radio['store']);
            $shortcode = end($store);
            $RefNumber = $radio['shortcode'];
            if ($RefNumber == 'NONE') {
                $players = Players::whereDate('TransTime', date('Y-m-d'))->where("BusinessShortCode", $shortcode);
            } else {
                $players = Players::whereDate('TransTime', date('Y-m-d'))->where("BusinessShortCode", $shortcode)->where('BillRefNumber', 'LIKE', '%' . $RefNumber . '%');
            }
        }
        $totalPlayers = $players->count();
        $totalAmount = $players->sum('TransAmount');
        $new_players = $players->where('id', '>', $index)->get();
        return $data = ['new_players' => $new_players, 'totalplayers' => $totalPlayers, 'totalAmount' => $totalAmount];
    }
    public function filter(Request $request)
    {

        $from_date = Carbon::parse($request->from_date);
        $to_date = Carbon::parse($request->to_date);
        // dd($from_date);
        $role = Auth::user()->role;
        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Developer') {
            $role = $request->radio;
        }
        $radio = Radio::where('name', $role)->first();
        $store = explode('@', $radio['store']);
        $shortcode = end($store);
        $RefNumber = $radio['shortcode'];

        if ($RefNumber == 'NONE') {
            $players = Players::where('TransTime', '>=', $from_date)->where('TransTime', '<=', $to_date)->where('BusinessShortCode', $shortcode)->get();
        } else {
            $players = Players::where('TransTime', '>=', $from_date)->where('TransTime', '<=', $to_date)->where('BusinessShortCode', $shortcode)->where('BillRefNumber', 'LIKE', '%' . $RefNumber . '%')->get();
        }

        $totalPlayers = $players->count();
        $totalAmount = $players->sum('TransAmount');
        // dd(['players' => $players, 'totalPlayers' => $totalPlayers, 'totalAmount' => $totalAmount]);
        return view('admin.filters', [
            'players' => $players, 'totalPlayers' => $totalPlayers, 'totalAmount' => $totalAmount, "fromDate" => $from_date,
            "toDate" => $to_date, 'radio' => $role
        ]);
    }

    public function winners(Request $request)
    {
        $players = Players::select(
            'MSISDN',
            'FirstName',
            DB::raw('COUNT(*) as transactions_count'),
            DB::raw('SUM(TransAmount) as total_trans_amount'),
            DB::raw('AVG(TransAmount) as average_trans_amount'),
            DB::raw('MIN(TransTime) as first_transaction'),
            DB::raw('MAX(TransTime) as last_transaction'),
            DB::raw('MIN(TransAmount) as min_trans_amount'),
            DB::raw('MAX(TransAmount) as max_trans_amount')
        )
            ->whereDate('TransTime', date('Y-m-d'))
            ->groupBy('MSISDN', 'FirstName');
        //if user is admin return all data
        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Developer') {
            $players = $players->get();
            //if user is radio presenter or other
        } else {
            $role = Auth::user()->role;
            $radio = Radio::where('name', $role)->first();
            $store = explode('@', $radio['store']);
            $shortcode = end($store);
            $RefNumber = $radio['shortcode'];
            //if shortcode does not have strict account number
            if ($RefNumber == 'NONE') {
                $players = $players
                    ->where("BusinessShortCode", $shortcode)
                    ->get();
            } else {
                $players = $players->where("BusinessShortCode", $shortcode)->where('BillRefNumber', 'LIKE', '%' . $RefNumber . '%')
                    ->get();
            }
        }

        return view('admin.winners', compact('players'));
    }
}
