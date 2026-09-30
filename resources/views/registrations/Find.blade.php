<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name ?? 'Gifts World Expo - Delhi' }} | Find Your Badge</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<div class="max-w-xl mx-auto px-4 py-8">

    {{-- Banner --}}
    <div class="rounded-2xl overflow-hidden mb-6">
        <img src="{{ asset('gift.jpg') }}" alt="{{ $event->name ?? 'Event Banner' }}" class="w-full object-cover">
    </div>

    {{-- Title --}}
    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
        {{ $event->name ?? 'Gifts World Expo - Delhi' }}
    </h1>

    <hr class="mb-8 border-gray-200">

    {{-- Error message agar registration na mila --}}
    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-300 text-red-700 rounded-xl p-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Search Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-10">

        <h2 class="text-2xl font-bold text-gray-900 mb-2">Find Your Badge</h2>
        <p class="text-gray-600 mb-6">Enter your Registration Number or Email Address, and we will find your registration.</p>

        <form action="{{ Route::has('registrations.find') ? route('registrations.find') : '#' }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block font-semibold text-gray-800 mb-2">Registration Number or Email <span class="text-red-500">*</span></label>
                <input type="text" name="search" value="{{ old('search') }}" required
                    placeholder="e.g. REG202600001 or your@email.com"
                    class="w-full border {{ $errors->has('search') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                @error('search') <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 transition text-white font-bold text-lg py-4 rounded-xl">
                Search
            </button>

            <p class="text-center text-gray-600 mt-4">
                New registration? <a href="{{ Route::has('registration.create') ? route('registration.create') : '#' }}" class="text-blue-600 font-semibold underline">Register here</a>
            </p>

        </form>
    </div>
</div>

</body>
</html>