<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BranchList extends Component
{

    public $regionValue = null;
    public $zoneValue = null;
    public $regions = ['North', 'South'];
    public $rgn = null;
    public $zne = null;
    public $dst = null;

    public function render()
    {
        return view('livewire.branch-list');
    }


    public function region($event)
    {

        if ($event != null) {
            $this->regionValue = Branch::where('region', $event)->groupBy('zone')->get();
            $this->rgn = $event;
        }
        if ($event == '') {
            $this->regionValue = null;
            $this->zoneValue = null;
        }
    }

    public function zone($event)
    {
        if ($event != null) {
            $this->zoneValue = Branch::where('zone', $event)->groupBy('district')->get();
            $this->zne = $event;
        }
        if ($event == '') {
            $this->zoneValue = null;
        }
    }

    public function district($event)
    {

        if ($event != null) {
//            DB::enableQueryLog();
            $this->districtValue = Branch::where('region', $this->rgn)->where('zone', $this->zne)->where('district', $event)->get();
//            dd(DB::getQueryLog());
        }
        if ($event == '') {
            $this->districtValue = null;
        }
    }
}
