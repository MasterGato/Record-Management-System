<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicantCreate;
use App\Models\EducationalAttainmentCreate;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\JobOffer;
use App\Models\WorkExperience;

class ApplicationController extends Controller
{
    // Show the form
    public function showForm()
    {
        $branches = Branch::all(); // Get all branches
        $jobOffers = JobOffer::all(); // Get all job offers
        return view('welcome', compact('branches', 'jobOffers')); // Pass both to the view
    }

    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'Typeofapplication' => 'required|string',
            'branch_id' => 'required|exists:branches,id',
            'job_offer_id' => 'required|exists:job_offers,id',
            'Dateofapplication' => 'required|date',
            'Controlnumber' => 'nullable|string',
            'Firstname' => 'nullable|string',
            'Lastname' => 'nullable|string',
            'Middleinitial' => 'nullable|string',
            'Gender' => 'nullable|string',
            'Contact' => 'nullable|string',
            'Email' => 'nullable|string',
            'Dateofbirth' => 'nullable|date',
            'Citizenship' => 'nullable|string',
            'Region' => 'nullable|string',
            'Province' => 'nullable|string',
            'City' => 'nullable|string',
            'Brgy' => 'nullable|string',
            'Zipcode' => 'nullable|string',
            'Password' => 'nullable|string',
            'InstitutionElem' => 'nullable|string',
            'InclusivedateElem' => 'nullable|string',
            'InstitutionHigh' => 'nullable|string',
            'InclusivedateHigh' => 'nullable|string',
            'InstitutionColl' => 'nullable|string',
            'InclusivedateColl' => 'nullable|string',
            'Company' => 'nullable|string',
            'Work' => 'nullable|string',
            'Years' => 'nullable|string',
            // Optional control number
        ]);

        // dd($validatedData['Typeofapplication'], $validatedData['branch_id'], $validatedData['job_offer_id'], $validatedData['Dateofapplication']);
        // dd($validatedData['Firstname'], $validatedData['Lastname'], $validatedData['Middleinitial'], $validatedData['Gender'], $validatedData['Contact'], $validatedData['Email'], $validatedData['Citizenship'], $validatedData['Region'], $validatedData['Province']);
        $applicant = ApplicantCreate::create([
            'Firstname' => $validatedData['Firstname'],
            'Lastname' => $validatedData['Lastname'],
            'Middleinitial' => $validatedData['Middleinitial'],
            'Gender' => $validatedData['Gender'],
            'Contact' => $validatedData['Contact'],
            'Email' => $validatedData['Email'],
            'Dateofbirth' => $validatedData['Dateofbirth'],
            'Citizenship' => $validatedData['Citizenship'],
            'Region' => $validatedData['Region'],
            'Province' => $validatedData['Province'],
            'City' => $validatedData['City'],
            'Brgy' => $validatedData['Brgy'],
            'Zipcode' => $validatedData['Zipcode'],
            'Password' => bcrypt("Password"), // Ensure the password is encrypted
            'branch_id' => $validatedData['branch_id'],
        ]);

        EducationalAttainmentCreate::create([
            'Level' => "Elementary",
            'Institution' => $validatedData['InstitutionElem'],
            'Inclusivedate' => $validatedData['InclusivedateElem'],
            'applicant_id' => $applicant->applicant_id
        ]);
        EducationalAttainmentCreate::create([
            'Level' => "High School",
            'Institution' => $validatedData['InstitutionHigh'],
            'Inclusivedate' => $validatedData['InclusivedateHigh'],
            'applicant_id' => $applicant->applicant_id
        ]);
        EducationalAttainmentCreate::create([
            'Level' => "College",
            'Institution' => $validatedData['InstitutionColl'],
            'Inclusivedate' => $validatedData['InclusivedateColl'],
            'applicant_id' => $applicant->applicant_id
        ]);
       
        
        Application::create([
            'Typeofapplication' => $validatedData['Typeofapplication'],
            'applicant_id' => $applicant->applicant_id,
            'branch_id' => $validatedData['branch_id'],
            'job_offer_id' => $validatedData['job_offer_id'],
            'Dateofapplication' => $validatedData['Dateofapplication'],
            'Controlnumber' => null,
            'status' => 'pending', // Set default status to pending
        ]);

        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }
}
