<x-filament::page>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold">Reports Dashboard</h1>
            <p class="text-sm text-gray-600">Generate various reports for applicants and users.</p>
        </div>

        <div class="flex justify-between gap-4">
            <!-- Hired Applicants Report Widget -->
            <div class="bg-white p-4 shadow rounded-lg text-center w-1/2">

                <form action="{{ url('/hired-applicants-report') }}" method="GET" target="_blank">
                    <h2 class="text-lg font-semibold">Hired Applicants Report</h2>
                    <p class="text-sm text-gray-600 mb-4">View report of hired applicants.</p>


                    <div class="mb-4">
                        <x-filament::input type="date" name="start_date" />
                        <x-filament::input type="date" name="end_date" />
                    </div>

                    <x-filament::button color="primary" type="submit">
                        Download Report
                    </x-filament::button>

                </form>
            </div>

            <!-- Rejected Applicants Report Widget -->
            <div class="bg-white p-4 shadow rounded-lg text-center w-1/2">

                <form action="{{ url('/rejected-applicants-report') }}" method="GET" target="_blank">
                    <h2 class="text-lg font-semibold">Rejected Applicants Report</h2>
                    <p class="text-sm text-gray-600 mb-4">View report of rejected applicants.</p>



                    <div class="mb-4">
                        <x-filament::input type="date" name="start_date" />
                        <x-filament::input type="date" name="end_date" />
                    </div>

                    <x-filament::button color="danger" type="submit">
                        Download Report
                    </x-filament::button>

                </form>
            </div>

            <!-- Returnee Applicants Report Widget -->
            <div class="bg-white p-4 shadow rounded-lg text-center w-1/2">

                <form action="{{ url('/returnee-applicants-report') }}" method="GET" target="_blank">
                    <h2 class="text-lg font-semibold">Returnee Applicants Report</h2>
                    <p class="text-sm text-gray-600 mb-4">View report of returnee applicants.</p>



                    <div class="mb-4">
                        <x-filament::input type="date" name="start_date" />
                        <x-filament::input type="date" name="end_date" />
                    </div>

                    <x-filament::button color="success" type="submit">
                        Download Report
                    </x-filament::button>

                </form>
            </div>

            <!-- Active Users Report Widget -->
            <div class="bg-white p-4 shadow rounded-lg text-center w-1/2">


                <form action="{{ url('/active-users-report') }}" method="GET" target="_blank">
                    <h2 class="text-lg font-semibold">Active Users Report</h2>
                    <p class="text-sm text-gray-600 mb-4">View report of all active users.</p>

                    <x-filament::button color="primary" type="submit">
                        Download Report
                    </x-filament::button>

                </form>
            </div>
        </div>
    </div>
</x-filament::page>
