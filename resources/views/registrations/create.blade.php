<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name ?? 'Gifts World Expo - Delhi' }} | Registration</title>
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

        {{-- Download Badge --}}

        @if (session('success'))
            <div
                class="mb-6 bg-green-50 border border-green-300 text-green-800 rounded-xl p-4 flex items-center justify-between gap-4">
                <div>
                    <p class="font-semibold">{{ session('success') }}</p>
                    <p class="text-sm text-green-700">Badge sent in your email. You can also download it below.</p>
                </div>

                @if (session('badge'))
                    <a href="{{ session('badge') }}" download target="_blank"
                        class="shrink-0 bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-3 rounded-lg">
                        Download your badge
                    </a>
                @endif
            </div>
        @endif

        {{-- General error summary --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-300 text-red-700 rounded-xl p-4">
                <p class="font-semibold mb-2">Form not submitted, Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-10">

            <form action="{{ route('registration.store') }}" method="POST">
                @csrf

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Visitor Registration</h2>

                {{-- Email --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Email Address <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full border {{ $errors->has('email') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Title / First Name / Last Name --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">Title <span
                                class="text-red-500">*</span></label>
                        <select name="title" required
                            class="w-full border {{ $errors->has('title') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                            <option value="">Select</option>
                            @foreach (['Mr.', 'Ms.', 'Mrs.', 'Dr.'] as $opt)
                                <option value="{{ $opt }}" {{ old('title') == $opt ? 'selected' : '' }}>
                                    {{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">First Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required
                            class="w-full border {{ $errors->has('first_name') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        @error('first_name')
                            <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">Last Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required
                            class="w-full border {{ $errors->has('last_name') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        @error('last_name')
                            <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Phone Number --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Phone Number <span
                            class="text-red-500">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required maxlength="10"
                        placeholder="10 digit mobile number"
                        class="w-full border {{ $errors->has('phone') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Gender --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Please select gender <span
                            class="text-red-500">*</span></label>
                    <select name="gender" required
                        class="w-full border {{ $errors->has('gender') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Job Title --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Job Title <span
                            class="text-red-500">*</span></label>
                    <select name="job_title" required
                        class="w-full border {{ $errors->has('job_title') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        <option value="owner" {{ old('job_title') == 'owner' ? 'selected' : '' }}>Owner / Proprietor
                        </option>
                        <option value="director" {{ old('job_title') == 'director' ? 'selected' : '' }}>Director
                        </option>
                        <option value="manager" {{ old('job_title') == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="executive" {{ old('job_title') == 'executive' ? 'selected' : '' }}>Executive
                        </option>
                        <option value="other" {{ old('job_title') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('job_title')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Job Function --}}
                <div class="mb-8">
                    <label class="block font-semibold text-gray-800 mb-2">Job Function <span
                            class="text-red-500">*</span></label>
                    <select name="job_function" required
                        class="w-full border {{ $errors->has('job_function') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        <option value="purchase" {{ old('job_function') == 'purchase' ? 'selected' : '' }}>Purchase /
                            Sourcing</option>
                        <option value="sales" {{ old('job_function') == 'sales' ? 'selected' : '' }}>Sales / Marketing
                        </option>
                        <option value="operations" {{ old('job_function') == 'operations' ? 'selected' : '' }}>
                            Operations</option>
                        <option value="other" {{ old('job_function') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('job_function')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <hr class="mb-8 border-gray-200">

                {{-- Company Details --}}
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Company details</h2>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Company Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}" required
                        class="w-full border {{ $errors->has('company_name') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    @error('company_name')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Address <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="address" value="{{ old('address') }}" required
                        class="w-full border {{ $errors->has('address') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Country dropdown --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Country <span
                            class="text-red-500">*</span></label>
                    <select name="country" required
                        class="w-full border {{ $errors->has('country') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        <option value="India" {{ old('country', 'India') == 'India' ? 'selected' : '' }}>India
                        </option>
                    </select>
                    @error('country')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Pincode <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="pincode" value="{{ old('pincode') }}" required maxlength="6"
                        class="w-full border {{ $errors->has('pincode') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    @error('pincode')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- State dropdown - saare Indian states/UTs --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">State <span
                            class="text-red-500">*</span></label>
                    <select name="state" required
                        class="w-full border {{ $errors->has('state') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        @foreach (['Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal', 'Andaman and Nicobar Islands', 'Chandigarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Jammu and Kashmir', 'Ladakh', 'Lakshadweep', 'Puducherry'] as $state)
                            <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                {{ $state }}</option>
                        @endforeach
                    </select>
                    @error('state')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- City - fillable field --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">City <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="city" value="{{ old('city') }}" required
                        placeholder="Enter your city"
                        class="w-full border {{ $errors->has('city') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    @error('city')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Website</label>
                    <input type="text" name="website" value="{{ old('website') }}"
                        class="w-full border {{ $errors->has('website') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    @error('website')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Industry segment that your company belongs to
                        <span class="text-red-500">*</span></label>
                    <select name="industry_segment" required
                        class="w-full border {{ $errors->has('industry_segment') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        <option value="retail" {{ old('industry_segment') == 'retail' ? 'selected' : '' }}>Retail
                        </option>
                        <option value="wholesale" {{ old('industry_segment') == 'wholesale' ? 'selected' : '' }}>
                            Wholesale / Distribution</option>
                        <option value="manufacturing"
                            {{ old('industry_segment') == 'manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                        <option value="other" {{ old('industry_segment') == 'other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    @error('industry_segment')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Primary nature of business <span
                            class="text-red-500">*</span></label>
                    <select name="business_nature" required
                        class="w-full border {{ $errors->has('business_nature') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        <option value="importer" {{ old('business_nature') == 'importer' ? 'selected' : '' }}>Importer
                        </option>
                        <option value="exporter" {{ old('business_nature') == 'exporter' ? 'selected' : '' }}>Exporter
                        </option>
                        <option value="trader" {{ old('business_nature') == 'trader' ? 'selected' : '' }}>Trader
                        </option>
                        <option value="other" {{ old('business_nature') == 'other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    @error('business_nature')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Please select your primary product group of
                        interest (select any one) <span class="text-red-500">*</span></label>
                    <select name="primary_product_group" required
                        class="w-full border {{ $errors->has('primary_product_group') ? 'border-red-500 ring-1 ring-red-400' : 'border-gray-200' }} bg-gray-50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">Select an option</option>
                        <option value="gifts" {{ old('primary_product_group') == 'gifts' ? 'selected' : '' }}>Gifts &
                            Novelty</option>
                        <option value="stationery"
                            {{ old('primary_product_group') == 'stationery' ? 'selected' : '' }}>Stationery & Paper
                        </option>
                        <option value="houseware" {{ old('primary_product_group') == 'houseware' ? 'selected' : '' }}>
                            Houseware</option>
                        <option value="other" {{ old('primary_product_group') == 'other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    @error('primary_product_group')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
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
                                    {{ in_array($value, old('additional_product_group', [])) ? 'checked' : '' }}
                                    class="h-5 w-5 border-gray-300 rounded text-red-600 focus:ring-red-400">
                                <span class="text-gray-800">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('additional_product_group')
                        <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Consent --}}
                <div class="mb-6 flex items-start gap-3">
                    <input type="checkbox" name="terms" id="terms" required
                        {{ old('terms') ? 'checked' : '' }}
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
                @error('terms')
                    <p class="text-red-600 text-sm -mt-4 mb-4">⚠ {{ $message }}</p>
                @enderror

                <div class="mb-8 flex items-start gap-3">
                    <input type="checkbox" name="agree_children_policy" id="agree_children_policy" required
                        {{ old('agree_children_policy') ? 'checked' : '' }}
                        class="mt-1 h-5 w-5 border-gray-300 rounded text-red-600 focus:ring-red-400">
                    <label for="agree_children_policy" class="text-gray-800">
                        <strong>Important:</strong> Children below 16 years of age are not permitted inside the
                        exhibition halls.
                        No refund will be provided for tickets purchased for children. <span
                            class="text-red-500">*</span>
                    </label>
                </div>
                @error('agree_children_policy')
                    <p class="text-red-600 text-sm -mt-4 mb-4">⚠ {{ $message }}</p>
                @enderror

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 transition text-white font-bold text-lg py-4 rounded-xl">
                    Submit
                </button>

                <p class="text-center text-gray-600 mt-4">
                    Already registered? <a
                        href="{{ route('registration.find') }}"
                        class="text-blue-600 font-semibold underline">Find your badge</a>
                </p>

            </form>
        </div>
    </div>

    <script>
        // Session expiry warning 
        const SESSION_LIFETIME_MINUTES = {{ config('session.lifetime', 120) }};
        const WARNING_BEFORE_MINUTES = 5;
        const warningTime = (SESSION_LIFETIME_MINUTES - WARNING_BEFORE_MINUTES) * 60 * 1000;

        if (warningTime > 0) {
            setTimeout(function() {
                const confirmed = confirm(
                    "Your session is about to expire.\n" +
                    "To save your data, please reload the page (your entered data will be safe if you reload immediately)."
                );
                if (confirmed) {
                    window.location.reload();
                }
            }, warningTime);
        }
    </script>

</body>

</html>
