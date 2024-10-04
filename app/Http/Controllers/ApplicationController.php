<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Show the form
    public function showForm()
    {
        return view('welcome');
    }

    // Handle form submission
    public function submitForm(Request $request)

    {


        $validatedData = $request->validate([
            'applicantType' => 'required|string',
            'branch' => 'required|string',
            'position' => 'required|string',
            'country' => 'required|string',
        ]);

        // Process the form data (e.g., store in the database, send email, etc.)
        // Example: Application::create($validatedData);

        // Redirect with success message
        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }
}
