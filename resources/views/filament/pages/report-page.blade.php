<x-filament::page>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold">Reports Dashboard</h1>
            <p class="text-sm text-gray-600">Generate various reports for applicants and users.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Hired Applicants Report Widget -->
            <div class="bg-white p-4 shadow rounded-lg text-center">
                <h2 class="text-lg font-semibold">Hired Applicants Report</h2>
                <p class="text-sm text-gray-600 mb-4">View report of hired applicants.</p>
                <a href="{{ url('/hired-applicants-report') }}" target="_blank">
                    <x-filament::button color="primary">
                        Download Report
                    </x-filament::button>
                </a>
            </div>

            <!-- Rejected Applicants Report Widget -->
            <div class="bg-white p-4 shadow rounded-lg text-center">
                <h2 class="text-lg font-semibold">Rejected Applicants Report</h2>
                <p class="text-sm text-gray-600 mb-4">View report of rejected applicants.</p>
                <a href="{{ url('/rejected-applicants-report') }}" target="_blank">
                    <x-filament::button color="danger">
                        Download Report
                    </x-filament::button>
                </a>
            </div>

            <!-- Returnee Applicants Report Widget -->
            <div class="bg-white p-4 shadow rounded-lg text-center">
                <h2 class="text-lg font-semibold">Returnee Applicants Report</h2>
                <p class="text-sm text-gray-600 mb-4">View report of returnee applicants.</p>
                <a href="{{ url('/returnee-applicants-report') }}" target="_blank">
                    <x-filament::button color="warning">
                        Download Report
                    </x-filament::button>
                </a>
            </div>

            <!-- Active Users Report Widget -->
            <div class="bg-white p-4 shadow rounded-lg text-center">
                <h2 class="text-lg font-semibold">Active Users Report</h2>
                <p class="text-sm text-gray-600 mb-4">View report of all active users.</p>
                <a href="{{ url('/active-users-report') }}" target="_blank">
                    <x-filament::button color="success">
                        Download Report
                    </x-filament::button>
                </a>
            </div>
        </div>
    </div>
</x-filament::page>
