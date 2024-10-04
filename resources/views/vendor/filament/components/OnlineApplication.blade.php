<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Application Form</title>
</head>
<body class="bg-gray-100">
  <header class="bg-gray-800 text-white py-4">
    <h1 class="text-2xl font-bold text-center">Online Application Form</h1>
  </header>

  <main class="flex min-h-screen justify-center min-h-screen mt-20">
    <form class="space-y-6 w-full max-w-lg">
      <!-- Applicant Type -->
      <fieldset>
        <legend class="text-lg font-semibold">1. What type of applicant are you?</legend>
        <div class="mt-2 space-y-2">
          <label class="flex items-center">
            <input type="radio" name="applicantType" value="new" class="mr-2">
            New Applicant
          </label>
          <label class="flex items-center">
            <input type="radio" name="applicantType" value="returnee" class="mr-2">
            Returnee Applicant
          </label>
        </div>
      </fieldset>

      <!-- Branch Selection -->
      <fieldset>
        <legend class="text-lg font-semibold">2. Choose your branch</legend>
        <select class="w-full py-2 px-3 border border-gray-300 rounded-md">
          <option value="koronadal">Koronadal</option>
          <option value="isulan">Isulan</option>
          <option value="polomolok">Polomolok</option>
          <option value="gensan">Gensan</option>
          <option value="tacurong">Tacurong</option>
          <option value="surallah">Surallah</option>
        </select>
      </fieldset>

      <!-- Position Applying For and Country of Choice -->
      <fieldset class="flex justify-between space-x-6">
        <div class="flex-1">
          <legend class="text-lg font-semibold">3. Position Applying For</legend>
          <select class="w-full py-2 px-3 border border-gray-300 rounded-md">
            <option value="domestic-helper">Domestic Helper</option>
            <option value="house-keeper">House Keeper</option>
            <option value="driver">Driver</option>
            <option value="mechanic">Mechanic</option>
          </select>
        </div>

        <div class="flex-1">
          <legend class="text-lg font-semibold">Country of Choice</legend>
          <select class="w-full py-2 px-3 border border-gray-300 rounded-md">
            <option value="dubai">Dubai</option>
            <option value="kuwait">Kuwait</option>
            <option value="singapore">Singapore</option>
          </select>
        </div>
      </fieldset>
    </form>
  </main>
</body>
</html>