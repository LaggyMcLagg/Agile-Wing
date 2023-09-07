<?php

namespace App\View\Components;

use Illuminate\View\Component;

class button extends Component
{
    public $type;
    public $class;
    public $modalId;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
        public function __construct($type = '', $class = '', $modalId)
    {
        $this->type = $type;
        $this->class = $class;
        $this->modalId = $modalId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.button');
    }
}
