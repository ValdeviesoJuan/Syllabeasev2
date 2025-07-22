<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShowRemarks extends Component
{
    public $srf;
    public $previous;

    public function __construct($srf = null, $previous = null)
    {
        $this->srf = $srf;
        $this->previous = $previous;
    }

    public function render()
    {
        return view('components.show-remarks');
    }
}
