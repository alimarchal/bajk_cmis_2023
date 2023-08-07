<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Installment extends Component
{

    public $total_installment = 0.00;

    public $principle_amount = 0.00;
    public $markup_amount = 0.00;
    public $installment_insurance = 0.00;


    public function render()
    {
        return view('livewire.installment');
    }


    public function updated()
    {
        $this->calculate();
    }

    public function calculate()
    {
        $this->total_installment = ( (float)$this->principle_amount + (float)$this->markup_amount + (float)$this->installment_insurance);
    }
}
