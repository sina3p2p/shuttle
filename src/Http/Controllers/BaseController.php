<?php

namespace Sina\Shuttle\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{

    public bool $is_api = false;

    public function __construct(Request $request) {
        $this->is_api = in_array('api',$request->route()->getAction('middleware'));
    }
    
}