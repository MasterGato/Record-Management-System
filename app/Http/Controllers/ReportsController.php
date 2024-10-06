<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    public function generateApplicantsReport()
    {

        $applications = Application::with('Applicant')->get();

        $pdf = Pdf::loadView('applicants_report', ['applications' => $applications]);

        return $pdf->stream('applicants_report.pdf');
    }
    
    public function generateHiredApplicantsReport()
    {

        $applications = Application::with('Applicant')->where('status', 'hired')->get();

        $pdf = Pdf::loadView('hired_applicants_report', ['applications' => $applications]);

        return $pdf->stream('hired_applicants_report.pdf');
    }
    public function generateRejectedApplicantsReport()
    {

        $applications = Application::with('Applicant')->where('status', 'rejected')->get();

        $pdf = Pdf::loadView('rejected_applicants_report', ['applications' => $applications]);

        return $pdf->stream('rejected_applicants_report.pdf');
    }

    public function generateReturneeApplicantsReport()
    {

        $applications = Application::with('Applicant')->where('Typeofapplication', 'returnee')->get();

        $pdf = Pdf::loadView('returnee_applicants_report', ['applications' => $applications]);

        return $pdf->stream('returnee_applicants_report.pdf');
    }

    public function generateActiveUserReport()
    {

        $users = User::with('branch')->where('status', 'Active')->get();

        $pdf = Pdf::loadView('active_users_report', ['employees' => $users]);

        return $pdf->stream('active_users_report.pdf');
    }
}
