<?php

namespace App\View\Components;

use Illuminate\Support\Facades\App;
use Illuminate\View\Component;
use NumberFormatter;

class Currency extends Component
{
    public $amount;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($amount)
    {
        $formtter = new NumberFormatter(App::currentLocale(), NumberFormatter::CURRENCY);
        $this->amount = $formtter->formatCurrency($amount, 'ILS');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.currency');
    }
}
