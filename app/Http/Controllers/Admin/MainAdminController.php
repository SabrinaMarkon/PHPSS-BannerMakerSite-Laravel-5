<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

class MainAdminController extends Controller
{
    // list all products for sale
    public function index() {
        return view('pages.admin.main');
    }
}