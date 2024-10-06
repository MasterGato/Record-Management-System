<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\JobOffer;

class JobApplicationForm extends Component
{
    public function render()
    {
        return view('livewire.job-application-form');
    }

    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'Typeofapplication' => 'required|string',
            'branch_id' => 'required|exists:branches,id',
            'job_offer_id' => 'required|exists:job_offers,id',
            'Dateofapplication' => 'required|date',
            'Controlnumber' => 'nullable|string', // Optional control number
        ]);

        Application::create([
            'Typeofapplication' => $validatedData['Typeofapplication'],
            'branch_id' => $validatedData['branch_id'],
            'job_offer_id' => $validatedData['job_offer_id'],
            'Dateofapplication' => $validatedData['Dateofapplication'],
            'Controlnumber' => $validatedData['Controlnumber'],
            'status' => 'pending', // Set default status to pending
        ]);

        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }
}
