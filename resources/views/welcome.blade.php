@extends('layouts.app')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media(prefers-color-scheme: dark) {
            .bg-dots {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(200,200,255,0.15)'/%3E%3C/svg%3E");
            }
        }

        @media(prefers-color-scheme: light) {
            .bg-dots {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,50,0.10)'/%3E%3C/svg%3E")
            }
        }
    </style>

    <nav class="flex justify-between px-5 py-2 bg-slate-900 items-center shadow-xl">
        <div>
            <h1 class="text-xs font-bold text-white">MMML Recruitment Service Inc.</h1>
        </div>


        <div>
            <a href="/admin"
                class="rounded border-2 border-slate-50 px-4 py-1 text-white font-semibold text-xs hover:bg-white hover:text-slate-950 delay-100 transition-all ">Login</a>
        </div>
    </nav>

    <div
        class="relative min-h-screen bg-gray-100 bg-center sm:flex sm:justify-center sm:items-center bg-dots dark:bg-gray-900 selection:bg-indigo-500 selection:text-white">


        <div class="grid md:grid-cols-2 items-center sm:grid-cols-1 p-4">
            <div class=" m-auto">
                <div class="font-bold w-72 m-auto" style="font-size: 70px">
                    Explore Thousands of Jobs

                </div>

                <div class="flex justify-center">
                    <button class="rounded shadow-xl px-2 py-2 bg-green-950 text-white w-full">Apply Now</button>
                </div>


            </div>

            <div class="rounded-xl overflow-hidden shadow sm:none xl:block xs:hidden">
                <img class="object-cover w-full"
                    src="https://img.freepik.com/free-photo/woman-with-headset-video-call_23-2148854894.jpg?w=826&t=st=1728085874~exp=1728086474~hmac=3497db3b6a42addd229d11efc1268d84f15a6423c7233ff92d7faff0d1e30eed"
                    alt="">
            </div>
        </div>


    </div>

    <div
        class="relative min-h-screen bg-gray-100 bg-center sm:flex sm:justify-center sm:items-center bg-dots dark:bg-gray-900 selection:bg-indigo-500 selection:text-white">

        <form action="{{ route('submitForm') }}" method="POST">
            @csrf

            <div class="grid xl:grid-cols-2 p-5 sm:grid-cols-1">

                <div class="rounded-xl shadow-lg p-2">
                    <div class="grid  xl:grid-cols-2 sm:grid-cols-1 gap-5 px-2">
                        <div>
                            <label for="Firstame" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                                name</label>
                            <input type="text" name="Firstname" id="Firstname"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="First Name" required />
                        </div>
                        <div>
                            <label for="Lastname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                name</label>
                            <input type="text" name="Lastname" id="Lastname"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Lastname" required />
                        </div>
                        <div>
                            <label for="Middlename"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middlename
                            </label>
                            <input type="text" name="Middleinitial" id="Contact"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Middlename" required />
                        </div>
                        <div>
                            <label for="Contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Contact</label>
                            <input type="text" name="Contact" id="Contact"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Contact" required />
                        </div>
                        <div>
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                            </label>
                            <input type="text" name="Email" id="Email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Email" required />
                        </div>
                        <div>
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                            <input type="text" name="Gender" id="Gender"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Gender" required />
                        </div>
                        <div>
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Birth
                            </label>
                            <input type="Date" name="Dateofbirth" id="Dateofbirth"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Date of Birth" required />
                        </div>
                        <div>
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Citizenship</label>
                            <input type="text" name="Citizenship" id="Citizenship"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Citizenship" required />
                        </div>



                        <div>
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Region</label>
                            <input type="text" name="Region" id="Region"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Region" required />
                        </div>
                        <div>
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Province
                            </label>
                            <input type="text" name="Province" id="Province"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Province" required />
                        </div>
                        <div>
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City
                            </label>
                            <input type="text" name="City" id="City"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="City" required />
                        </div>

                        <div>
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangy
                            </label>
                            <input type="text" name="Brgy" id="Barangy"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Barangy" required />
                        </div>

                        <div>
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zip Code
                            </label>
                            <input type="text" name="Zipcode" id="Barangy"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Barangy" required />
                        </div>

                        <hr>
                        <h2>Educational Attainment</h2>
                        <h3>Elementary</h3>
                        <div>

                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Institution</label>
                            <input type="text" name="InstitutionElem" id="Institution"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Institution" required />
                        </div>

                        <div>

                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Inclusivedate</label>
                            <input type="text" name="InclusivedateElem" id="Inclusivedate"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Inclusivedate" required />
                        </div>
                        <h3>High School</h3>
                        <div>

                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Institution</label>
                            <input type="text" name="InstitutionHigh" id="Institution"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Institution" required />
                        </div>

                        <div>

                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Inclusivedate</label>
                            <input type="text" name="InclusivedateHigh" id="Inclusivedate"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Inclusivedate" required />
                        </div>

                        <h3>Higher</h3>
                        <div>

                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Institution</label>
                            <input type="text" name="InstitutionColl" id="Institution"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Institution" required />
                        </div>

                        <div>

                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Inclusivedate</label>
                            <input type="text" name="InclusivedateColl" id="Inclusivedate"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Inclusivedate" required />
                        </div>
                        
                        
                     
                        <br>

                            <div>
                                <h1>Work Experience</h1>
                                <label for="first_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                                <input type="text" name="Company" id="Institution"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Institution" required />
                            </div>
                            <div>

                                <label for="first_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Work</label>
                                <input type="text" name="Work" id="Institution"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Institution" required />
                            </div>
    
                            <div>
    
                                <label for="first_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Years</label>
                                <input type="text" name="Years" id="Inclusivedate"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Inclusivedate" required />
                            </div>


                            <div>
                                <label for="Typeofapplication"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type of
                                    Application
                                </label>

                                <select name="Typeofapplication" id="Typeofapplication"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Barangy" required />
                                <option value="NewApplication">New Application</option>
                                <option value="Returnee">Returnee</option>
                                </select>
                            </div>
                            <div>
                                <label for="JobOffer"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Job
                                    Offer</label>
                                <select name="job_offer_id" id="JobOffer" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select Job Offer</option>
                                    @foreach ($jobOffers as $jobOffer)
                                        <option value="{{ $jobOffer->id }}">{{ $jobOffer->Job }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="Branch"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Branch</label>
                                <select name="branch_id" id="Branch" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->branchname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="first_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date
                                    of application
                                </label>
                                <input type="Date" name="Dateofapplication" id="Dateofapplication"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Date of Application" required />
                            </div>

                            <div class="col-span-2">
                                <button type="submit"
                                    class="bg-blue-500 text-white font-semibold text-sm rounded-lg px-4 py-2 hover:bg-blue-600 transition-all">Submit</button>
                            </div>


                    </div>
                </div>
        </form>

        <div class="items-center  flex justify-center">
            <div class="text-3xl font-sans font-mediuml p-5">
                MMML Recruitment Services, Inc. is a land based recruitment agency duly licensed by the (POEA) Philippine
                Overseas Employment Administration and Department of Labor and Employment
                (DOLE) specializing in the career placement of Filipino professionals and skilled workers for overseas
                employment.
            </div>
        </div>


    </div>
    </div>
    </form>

    </div>
@endsection
