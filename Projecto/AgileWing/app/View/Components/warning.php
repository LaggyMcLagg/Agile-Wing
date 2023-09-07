<?php

namespace App\View\Components;

use Illuminate\View\Component;

class warning extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $modalId;
    public $title;
    public $body;

    public function __construct($modalId, $title, $body)
    {
        $this->modalId = $modalId;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.warning');
    }
}
