<?php

namespace Modules\Module\Http\Controllers;

use App\Http\Controllers\Controller;

class ModuleController extends Controller
{
    public function index()
    {
        return view('module::index');
    }
}