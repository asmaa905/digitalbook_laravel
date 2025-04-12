<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;

class BaseController extends Controller

{
    protected $viewPath = 'reader.';
    
    protected function view($view, $data = [])
    {
        return view($this->viewPath . $view, $data);
    }
}