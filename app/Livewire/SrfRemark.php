<?php

namespace App\Livewire;

use Livewire\Component;

class SrfRemark extends Component
{
    public $srf;
    public $remark;
    public $showRemark = false;
    public $prevSrf;
    public $showPrev = false;

    protected $listeners = ['toggleShowPrev' => 'setShowPrev'];
    public function mount($srf = null, $remark = null, $prevSrf = null)
    {
        $this->srf = $srf;
        $this->remark = $remark;
        $this->prevSrf = $prevSrf;
    }

    public function setShowPrev($show)
    {
        $this->showPrev = $show;
    }
    public function getShouldShowIconProperty()
    {
        return ($this->srf && $this->srf['srf_yes_no'] === 'no') ||
               ($this->showPrev && $this->prevSrf && $this->prevSrf->srf_yes_no === 'no');
    }

    public function render()
    {
        return view('livewire.srf-remark');
    }
}
