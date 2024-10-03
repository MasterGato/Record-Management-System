<!-- resources/views/apply.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Submit Your Application</h1>
    
    <form action="{{ route('applications.store') }}" method="POST">
        @csrf

        <!-- Application Details -->
        <h2>Application Details</h2>
        <div class="form-group">
            <label for="type_of_application">Type of Application</label>
            <select name="type_of_application" id="type_of_application" class="form-control" required>
                <option value="type1">Type 1</option>
                <option value="type2">Type 2</option>
            </select>
        </div>

        <div class="form-group">
            <label for="job_offer">Job Offer</label>
            <select name="job_offer" id="job_offer" class="form-control" required>
                <option value="offer1">Offer 1</option>
                <option value="offer2">Offer 2</option>
            </select>
        </div>

        <div class="form-group">
            <label for="branch">Branch</label>
            <select name="branch" id="branch" class="form-control" required>
                <option value="branch1">Branch 1</option>
                <option value="branch2">Branch 2</option>
            </select>
        </div>

        <div class="form-group">
            <label for="date_of_application">Date of Application</label>
            <input type="date" name="date_of_application" id="date_of_application" class="form-control" value="{{ now()->toDateString() }}" required>
        </div>

        <!-- Applicant Information -->
        <h2>Applicant Information</h2>

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="middle_initial">Middle Initial</label>
            <input type="text" name="middle_initial" id="middle_initial" class="form-control">
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" name="contact" id="contact" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="citizenship">Citizenship</label>
            <input type="text" name="citizenship" id="citizenship" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="region">Region</label>
            <input type="text" name="region" id="region" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="province">Province</label>
            <input type="text" name="province" id="province" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" id="city" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="barangay">Barangay</label>
            <input type="text" name="barangay" id="barangay" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="zipcode">Zipcode</label>
            <input type="text" name="zipcode" id="zipcode" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <!-- Educational Attainments -->
        <h2>Educational Attainment</h2>
        <div id="education-repeatable">
            <div class="education-group">
                <div class="form-group">
                    <label for="education_level">Education Level</label>
                    <input type="text" name="educational_attainments[0][education_level]" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="institution_name">Institution Name</label>
                    <input type="text" name="educational_attainments[0][institution_name]" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="inclusive_dates">Inclusive Dates</label>
                    <input type="text" name="educational_attainments[0][inclusive_dates]" class="form-control" required>
                </div>

                <button type="button" class="btn btn-danger remove-education">Remove</button>
            </div>
        </div>
        <button type="button" id="add-education" class="btn btn-secondary">Add Educational Attainment</button>

        <!-- Work Experience -->
        <h2>Work Experience</h2>
        <div id="work-experience-repeatable">
            <div class="work-experience-group">
                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" name="work_experiences[0][company_name]" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="work_position">Work Position</label>
                    <input type="text" name="work_experiences[0][work_position]" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="years_of_experience">Years of Experience</label>
                    <input type="text" name="work_experiences[0][years_of_experience]" class="form-control" required>
                </div>

                <button type="button" class="btn btn-danger remove-work-experience">Remove</button>
            </div>
        </div>
        <button type="button" id="add-work-experience" class="btn btn-secondary">Add Work Experience</button>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Submit Application</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Add more educational attainments dynamically
    document.getElementById('add-education').addEventListener('click', function () {
        let educationIndex = document.querySelectorAll('.education-group').length;
        let newEducation = `
            <div class="education-group">
                <div class="form-group">
                    <label for="education_level">Education Level</label>
                    <input type="text" name="educational_attainments[${educationIndex}][education_level]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="institution_name">Institution Name</label>
                    <input type="text" name="educational_attainments[${educationIndex}][institution_name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="inclusive_dates">Inclusive Dates</label>
                    <input type="text" name="educational_attainments[${educationIndex}][inclusive_dates]" class="form-control" required>
                </div>
                <button type="button" class="btn btn-danger remove-education">Remove</button>
            </div>`;
        document.getElementById('education-repeatable').insertAdjacentHTML('beforeend', newEducation);
    });

    // Add more work experiences dynamically
    document.getElementById('add-work-experience').addEventListener('click', function () {
        let workExperienceIndex = document.querySelectorAll('.work-experience-group').length;
        let newWorkExperience = `
            <div class="work-experience-group">
                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" name="work_experiences[${workExperienceIndex}][company_name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="work_position">Work Position</label>
                    <input type="text" name="work_experiences[${workExperienceIndex}][work_position]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="years_of_experience">Years of Experience</label>
                    <input type="text" name="work_experiences[${workExperienceIndex}][years_of_experience]" class="form-control" required>
                </div>
                <button type="button" class="btn btn-danger remove-work-experience">Remove</button>
            </div>`;
        document.getElementById('work-experience-repeatable').insertAdjacentHTML('beforeend', newWorkExperience);
    });

    // Remove education
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-education')) {
            e.target.closest('.education-group').remove();
        }
    });

    // Remove work experience
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-work-experience')) {
            e.target.closest('.work-experience-group').remove();
        }
    });
</script>
@endsection
