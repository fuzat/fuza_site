<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard()
    {
        $page_setting = ['title' => __('datametas.title.dashboard')];
        return view('admin.dashboard', compact(['page_setting']));
    }
}
