<div class="max-w-3xl mx-auto py-6">
  @if (session()->has('message'))
      <div class="bg-green-500 text-white p-4 mb-4 rounded-lg">
          {{ session('message') }}
      </div>
  @endif

  <form wire:submit.prevent="submit" class="space-y-6">
      <!-- Type of Application -->
      <div class="mb-4">
          <label for="typeOfApplication" class="block text-sm font-medium text-gray-700">Type of Application</label>
          <select id="typeOfApplication" wire:model="typeOfApplication" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
              <option value="">Select</option>
              <option value="newapplicant">New Applicant</option>
              <option value="returnee">Returnee</option>
          </select>
          @error('typeOfApplication') 
              <span class="text-red-500 text-sm">{{ $message }}</span>
          @enderror
      </div>

      <!-- Applicant Information -->
      <div class="mb-4">
          <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
          <input id="firstName" type="text" wire:model="firstName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter your first name">
          @error('firstName') 
              <span class="text-red-500 text-sm">{{ $message }}</span>
          @enderror
      </div>

     

      <!-- Submit Button -->
      <div class="flex justify-end">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rou
