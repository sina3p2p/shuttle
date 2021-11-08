<?php

namespace Sina\Shuttle\View;

use Illuminate\View\Component;
use Sina\Shuttle\Models\ScaffoldInterface;

class Form extends Component
{
    public $edit = false;

    public ScaffoldInterface $scaffoldInterface;

    public $dataTypeContent;

    public function __construct($scaffoldInterface, $dataTypeContent=null)
    {
        $this->scaffoldInterface = $scaffoldInterface;
        $this->dataTypeContent   = $dataTypeContent ? $dataTypeContent : app($scaffoldInterface->model);
    }

    public function render()
    {
        return view('shuttle::form');
    }
}
