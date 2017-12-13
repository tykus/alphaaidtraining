<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        return response()->json(['message' => 'Thank you']);
    }
}
