<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HiredApplicantsReportController extends Controller
{
    public function index()
    {
        // Fetch hired applications
        $hiredApplications = Application::where('status', 'Hired')->with('applicant')->get();

        // Return view with the data
        return view('reports.hired_applicants_report', compact('hiredApplications'));
    }
}
