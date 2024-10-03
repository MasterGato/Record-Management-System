<x-filament::page>
    <h1 class="text-2xl font-bold">Active Users Report</h1>

    <button id="printButton" class="mt-4 bg-blue-500 text-white p-2 rounded">
        Print Report
    </button>

    <table class="mt-4 w-full border border-collapse">
        <thead>
            <tr>
                <th class="border p-2">Username</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Contact</th>
                <th class="border p-2">Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activeUsers as $user)
                <tr>
                    <td class="border p-2">{{ $user->name }}</td>
                    <td class="border p-2">{{ $user->email }}</td>
                    <td class="border p-2">{{ $user->contact }}</td>
                    <td class="border p-2">{{ $user->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <script>
        document.getElementById('printButton').onclick = function () {
            window.print();
        };
    </script>
</x-filament::page>
