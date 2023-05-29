<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\form;

class FormController extends Controller
{

    
    public function showForm()
    {
        return view('form');
    }

    public function submitForm(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha|max:255',
            'email' => 'required|email|max:255',
            'phone' => [
                'required',
                'regex:/^\+\d{1,3}\d{10}$/',
            ],
        ], [
            'phone.regex' => 'The phone number must be in the format "+[country code][10-digit number]".',
        ]);

        if ($validator->fails()) {
            return redirect('/form')
                ->withErrors($validator)
                ->withInput();
        }
        
        $formData = new Form();
        $formData->name = $request->input('name');
        $formData->email = $request->input('email');
        $formData->phone = $request->input('phone');
        $formData->save();

        return redirect('/form')->with('success', 'Form submitted successfully!');
    }
}
