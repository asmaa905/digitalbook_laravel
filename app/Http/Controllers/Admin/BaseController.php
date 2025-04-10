<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $viewPath = 'admin.';
    
    protected function view($view, $data = [])
    {
        return view($this->viewPath . $view, $data);
    }
}