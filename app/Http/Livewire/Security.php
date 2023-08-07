<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Security extends Component
{

    public $selection = null;

    public function render()
    {
        return view('livewire.security');
    }

    public function updated()
    {
        $value = $this->selection;
        $this->selection = '';
        $this->selection = $value;

//        dd($this->selection);
    }

    public function selectionItem($event)
    {
        if ($event == '') {
            $this->selection = 'None';
        } else {
            $this->selection = $event;
        }

    }
}
