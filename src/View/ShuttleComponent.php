<?php

namespace Sina\Shuttle\View;


class ShuttleComponent
{

    protected $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function render()
    {
        return view($this->view);
    }
}