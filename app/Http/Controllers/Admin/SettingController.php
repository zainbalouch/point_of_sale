<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function general() {
        return view('admin.settings.general');
    }

    public function store(Request $request) {
        $request->validate([
            'invoice_number_prefix' => 'required'
        ]);

        $requestData = $request->except(['_token', '_method']);

        setting($requestData)->save();

        session()->flash('success', 'Updated successfully');

        return redirect()->route('admin.settings.general');
    }
}
