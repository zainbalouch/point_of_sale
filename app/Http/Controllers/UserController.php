<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware(['role:super_admin']);
    }

    public function index() {
        return view('users.index');
    }
}
