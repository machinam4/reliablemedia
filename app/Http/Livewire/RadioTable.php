<?php

namespace App\Http\Livewire;

use App\Models\Radio;
use Livewire\Component;

class RadioTable extends Component
{

    protected function getListeners()
    {

        return ['radioAdded' => 'render'];

    }

    public function render()
    {
        $radios= Radio::all();
        return view('livewire.radio-table',  ['radios'=>$radios]);
    }
}
