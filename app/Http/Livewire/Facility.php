<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Facility extends Component
{

    public $nature_of_facility = null;

    public $customer = null;

    public $type_of_facility = [];
    public $type_of_facility_flag = false;

    public $check_flag = false;
    public $nature_of_facility_selected = null;

    public function render()
    {
        $this->nature_of_facility = Product::all();
        return view('livewire.facility');
    }

    public function nature_of_facility($event)
    {
//        dd($event);
        $this->check_flag = true;
        if ($event != null) {
            if ($event == '1') {
                $this->type_of_facility = Product::find($event)->product_type;
                $this->type_of_facility_flag = true;
            } elseif ($event == '2') {
                $this->type_of_facility = Product::find($event)->product_type;
                $this->type_of_facility_flag = true;
            } elseif ($event == '3') {
                $this->type_of_facility = Product::find($event)->product_type;
                $this->type_of_facility_flag = true;
            } elseif ($event == '4') {
                $this->type_of_facility = Product::find($event)->product_type;
                $this->type_of_facility_flag = true;
            }

        }


    }
}
