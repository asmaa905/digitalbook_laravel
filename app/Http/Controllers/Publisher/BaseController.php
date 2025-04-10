<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $viewPath = 'publisher.';
    
    protected function view($view, $data = [])
    {
        return view($this->viewPath . $view, $data);
    }
}