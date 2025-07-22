<?php

namespace App\Livewire;

use Livewire\Component;

class SrfRemark extends Component
{
    public $srf;
    public $remark;
    public $showRemark = false;
    public $prevSrf;

    public function getShouldShowIconProperty()
    {
        return ($this->srf && $this->srf['srf_yes_no'] === 'no') ||
               ($this->prevSrf && $this->prevSrf->srf_yes_no === 'no');
    }

    public function render()
    {
        return view('livewire.srf-remark');
    }
}
