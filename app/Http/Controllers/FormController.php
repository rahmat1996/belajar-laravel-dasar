<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormController extends Controller
{
    // show form
    public function form(): Response
    {
        return response()->view("form");
    }

    // submit form
    public function submitForm(Request $request): Response
    {
        $name = $request->input("name");
        return response()->view('hello', [
            "name" => $name
        ]);
    }
}
