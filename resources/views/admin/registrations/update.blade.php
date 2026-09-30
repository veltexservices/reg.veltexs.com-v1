<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name ?? 'Gifts World Expo - Delhi' }} | Update Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <div class="max-w-3xl mx-auto px-4 py-8">

        {{-- Banner --}}
        <div class="rounded-2xl overflow-hidden mb-6">
            <img src="{{ asset('gift.jpg') }}" alt="{{ $event->name ?? 'Event Banner' }}" class="w-full object-cover">
        </div>

        {{-- Title --}}
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
            {{ $event->name ?? 'Gifts World Expo - Delhi' }}
        </h1>

        {{-- Date & Location --}}
        <div class="text-gray-600 mb-2 flex items-start gap-2">
            <span>📅</span>
            <span>
                {{ $event->date_range ?? '30 Jul to 1 Aug 26 | 10:00 AM' }} |
                <span class="text-red-600 font-semibold">{{ $event->status ?? 'Upcoming' }}</span>
            </span>
        </div>
        <div class="text-gray-600 mb-6 flex items-start gap-2">
            <span>📍</span>
            <span>{{ $event->venue ?? 'Hall 1, 2, 3, 4, and 5 | Hall 6 Stationery and Paper Gifting, Bharat Mandapam, New Delhi, India' }}</span>
        </div>

        <hr class="mb-8 border-gray-200">

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-10">

            <form
                action="{{ Route::has('registrations.update') ? route('registrations.update', $registration->id) : '#' }}"
                method="POST">
                @csrf

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Update Registration</h2>

                {{-- Email --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Email Address <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $registration->email ?? '') }}" required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Title / First Name / Last Name --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">Title <span
                                class="text-red-500">*</span></label>
                        <select name="title" required
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                            @foreach (['Mr.', 'Ms.', 'Mrs.', 'Dr.'] as $opt)
                                <option value="{{ $opt }}"
                                    {{ old('title', $registration->title ?? '') == $opt ? 'selected' : '' }}>
                                    {{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">First Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="first_name"
                            value="{{ old('first_name', $registration->first_name ?? '') }}" required
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">Last Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="last_name"
                            value="{{ old('last_name', $registration->last_name ?? '') }}" required
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    </div>
                </div>

                {{-- Phone Number --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Phone Number <span
                            class="text-red-500">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone', $registration->phone ?? '') }}"
                        required maxlength="10"
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gender --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Please select gender <span
                            class="text-red-500">*</span></label>
                    <select name="gender" required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        @foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('gender', $registration->gender ?? '') == $val ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Job Title --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Job Title <span
                            class="text-red-500">*</span></label>
                    <select name="job_title" required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        @foreach (['owner' => 'Owner / Proprietor', 'director' => 'Director', 'manager' => 'Manager', 'executive' => 'Executive', 'other' => 'Other'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('job_title', $registration->job_title ?? '') == $val ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Job Function --}}
                <div class="mb-8">
                    <label class="block font-semibold text-gray-800 mb-2">Job Function <span
                            class="text-red-500">*</span></label>
                    <select name="job_function" required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        @foreach (['purchase' => 'Purchase / Sourcing', 'sales' => 'Sales / Marketing', 'operations' => 'Operations', 'other' => 'Other'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('job_function', $registration->job_function ?? '') == $val ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <hr class="mb-8 border-gray-200">

                {{-- Company Details --}}
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Company details</h2>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Company Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="company_name"
                        value="{{ old('company_name', $registration->company_name ?? '') }}" required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Address <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="address" value="{{ old('address', $registration->address ?? '') }}"
                        required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Country <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="country" value="{{ old('country', $registration->country ?? '') }}"
                        required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Pincode <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="pincode" value="{{ old('pincode', $registration->pincode ?? '') }}"
                        required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">State <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="state" value="{{ old('state', $registration->state ?? '') }}"
                        required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">City <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="city" value="{{ old('city', $registration->city ?? '') }}"
                        required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Website</label>
                    <input type="text" name="website" value="{{ old('website', $registration->website ?? '') }}"
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Industry segment that your company belongs to
                        <span class="text-red-500">*</span></label>
                    <select name="industry_segment" required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        @foreach (['retail' => 'Retail', 'wholesale' => 'Wholesale / Distribution', 'manufacturing' => 'Manufacturing', 'other' => 'Other'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('industry_segment', $registration->industry_segment ?? '') == $val ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Primary nature of business <span
                            class="text-red-500">*</span></label>
                    <select name="business_nature" required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        @foreach (['importer' => 'Importer', 'exporter' => 'Exporter', 'trader' => 'Trader', 'other' => 'Other'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('business_nature', $registration->business_nature ?? '') == $val ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Please select your primary product group of
                        interest (select any one) <span class="text-red-500">*</span></label>
                    <select name="primary_product_group" required
                        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        @foreach (['gifts' => 'Gifts & Novelty', 'stationery' => 'Stationery & Paper', 'houseware' => 'Houseware', 'other' => 'Other'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('primary_product_group', $registration->primary_product_group ?? '') == $val ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-8">
                    <label class="block font-semibold text-gray-800 mb-2">Please select additional product groups of
                        interest (multiple selections) <span class="text-red-500">*</span></label>

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 gap-3 border {{ $errors->has('additional_product_group') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-4">
                        @foreach ([
                            'gifts' => 'Gifts & Novelty',
                            'stationery' => 'Stationery & Paper',
                            'houseware' => 'Houseware',
                            'toys' => 'Toys',
                            'other' => 'Other',
                        ] as $value => $label)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="additional_product_group[]" value="{{ $value }}"
                                    {{ in_array($value, old('additional_product_group', $registration->additional_product_group ?? [])) ? 'checked' : '' }}
                                    class="h-5 w-5 border-gray-300 rounded text-red-600 focus:ring-red-400">
                                <span class="text-gray-800">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('additional_product_group')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-8 flex items-center gap-3">
                    <input type="checkbox" name="status" id="status" value="1"
                        {{ old('status', $registration->status ?? true) ? 'checked' : '' }}
                        class="h-5 w-5 border-gray-300 rounded text-green-600 focus:ring-green-400">
                    <label for="status" class="text-gray-800 font-semibold">Active Registration</label>
                </div>

                {{-- Consent --}}
                <div class="mb-6 flex items-start gap-3">
                    <input type="checkbox" name="terms" id="terms" required
                        {{ old('terms', $registration->terms ?? false) ? 'checked' : '' }}
                        class="mt-1 h-5 w-5 border-gray-300 rounded text-red-600 focus:ring-red-400">
                    <label for="terms" class="text-gray-800">
                        I have read and agree to the events
                        <a href="#" class="text-blue-600 font-semibold underline">Privacy Policy</a>,
                        <a href="#" class="text-blue-600 font-semibold underline">Terms &amp; Conditions</a>
                        and by continuing to register, I allow {{ $event->name ?? 'Gifts World Expo Delhi 2026' }} to
                        contact me
                        with updates, relevant promotions, and information about its present and future events
                    </label>
                </div>

                <div class="mb-8 flex items-start gap-3">
                    <input type="checkbox" name="agree_children_policy" id="agree_children_policy" required
                        {{ old('agree_children_policy', $registration->agree_children_policy ?? false) ? 'checked' : '' }}
                        class="mt-1 h-5 w-5 border-gray-300 rounded text-red-600 focus:ring-red-400">
                    <label for="agree_children_policy" class="text-gray-800">
                        <strong>Important:</strong> Children below 16 years of age are not permitted inside the
                        exhibition halls.
                        No refund will be provided for tickets purchased for children. <span
                            class="text-red-500">*</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 transition text-white font-bold text-lg py-4 rounded-xl">
                    Update
                </button>

                <p class="text-center text-gray-600 mt-4">
                    <a href="{{ Route::has('registrations.index') ? route('registrations.index') : '#' }}"
                        class="text-blue-600 font-semibold underline">Back to registrations</a>
                </p>

            </form>
        </div>
    </div>

</body>

</html>
