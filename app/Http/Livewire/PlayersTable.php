<?php

namespace App\Http\Livewire;

use App\Models\mpesa;
use App\Models\Radio;
use App\Models\Players;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PlayersTable extends Component
{
    protected function getListeners()

    {

        return ['getPlayers' => 'render'];
    }
    public function render()
    {
        //if user is admin return all data
        // if (Auth::user()->role == 'Jamii') {
        //     $players = Players::whereDate('TransTime', date('Y-m-d'))->where('BillRefNumber', '7296354')->orderBy('TransTime', 'DESC')->limit(20)->get();
        //     return view('livewire.players-table', ['players' => $players]);
        // }
        //if user is admin return all data
        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Developer') {
            $players = Players::where('BillRefNumber', '!=', '7296354')->orderBy('TransTime', 'DESC')->limit(20)->get();
            return view('livewire.players-table', ['players' => $players]);
            // if user is radio station, return specific data
        } else {
            $role = Auth::user()->role;
            $radio = Radio::where('name', $role)->first();
            $store = explode('@', $radio['store']);
            $shortcode = end($store);
            $RefNumber = $radio['shortcode'];
            if ($RefNumber == 'NONE') {
                $players = Players::whereDate('TransTime', date('Y-m-d'))->where("BusinessShortCode", $shortcode)->orderBy('TransTime', 'DESC')->limit(20)->get();
            } else {
                $players = Players::whereDate('TransTime', date('Y-m-d'))->where("BusinessShortCode", $shortcode)->where('BillRefNumber', 'LIKE', '%' . $RefNumber . '%')->orderBy('TransTime', 'DESC')->limit(20)->get();
            }
            return view('livewire.players-table', ['players' => $players]);
        }
    }
}
