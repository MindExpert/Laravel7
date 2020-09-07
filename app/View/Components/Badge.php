<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{

    /**
     * The alert type.
     *
     * @var string
     */
    public $type;

    /**
     * The alert condition.
     *
     * @var string
     */
    public $show;

    /**
     * The alert message.
     *
     * @var string
     */
    public $message;

    /**
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $show)
    {
        $this->type = $type;
        $this->show = $show;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.badge');
    }
}
