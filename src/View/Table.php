<?php

namespace Sina\Shuttle\View;

use Illuminate\View\Component;
use Sina\Shuttle\Models\ScaffoldInterface;
use stdClass;

class Table extends Component
{
    public string $action = '';

    // public ScaffoldInterface $scaffoldInterface;
    public $scaffoldInterfaceRows;

    public $dataTypeContent;

    public $scaffoldInterface;

    public function __construct($scaffoldInterfaceRows, $action = "")
    {
        $this->scaffoldInterfaceRows = $scaffoldInterfaceRows;
        $this->action                = $action;
    }

    public function render()
    {
        return view('shuttle::table');
    }
}
