<?php

namespace Sina\Shuttle\View;

use Illuminate\View\Component;
use Sina\Shuttle\Models\ScaffoldInterface;
use stdClass;

class Form extends Component
{
    public bool $edit = false;
    public string $action = '';

    // public ScaffoldInterface $scaffoldInterface;
    public $scaffoldInterfaceRows;

    public $dataTypeContent;

    public $scaffoldInterface;

    public function __construct($scaffoldInterfaceRows, $dataTypeContent = null, $action = "", $edit = false)
    {
        $this->scaffoldInterfaceRows = $scaffoldInterfaceRows;
        $this->dataTypeContent       = $dataTypeContent ?? new stdClass;
        $this->edit                  = $edit;
        $this->action                = $action;
        $this->scaffoldInterface = new ScaffoldInterface();
    }

    public function render()
    {
        return view('shuttle::form');
    }
}
