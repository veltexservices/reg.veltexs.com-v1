<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name ?? 'Gifts World Expo - Delhi' }} | Your Badge</title>
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

        {{-- Success message --}}
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-300 text-green-700 rounded-xl p-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Badge Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            {{-- Badge Header --}}
            <div class="bg-red-600 text-white p-6 md:p-8 text-center">
                <p class="text-sm uppercase tracking-wide opacity-80 mb-1">Your Registration</p>
                <h2 class="text-2xl md:text-3xl font-extrabold">
                    {{ $registration->full_name ?? trim(($registration->first_name ?? '') . ' ' . ($registration->last_name ?? '')) }}
                </h2>
                <p class="mt-2 text-lg font-mono tracking-widest bg-white/20 inline-block px-4 py-1 rounded-lg">
                    {{ $registration->registration_no }}
                </p>
                <p class="mt-3">
                    @if ($registration->status)
                        <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Active</span>
                    @else
                        <span class="bg-gray-400 text-white text-xs font-bold px-3 py-1 rounded-full">Inactive</span>
                    @endif
                </p>
            </div>

            {{-- Visitor Details --}}
            <div class="p-6 md:p-10">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Visitor Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-8">
                    <div>
                        <p class="text-sm text-gray-500">Full Name</p>
                        <p class="font-semibold text-gray-800">{{ $registration->title }}
                            {{ $registration->full_name ?? trim(($registration->first_name ?? '') . ' ' . ($registration->last_name ?? '')) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email Address</p>
                        <p class="font-semibold text-gray-800">{{ $registration->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone Number</p>
                        <p class="font-semibold text-gray-800">{{ $registration->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-semibold text-gray-800 capitalize">{{ $registration->gender ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Job Title</p>
                        <p class="font-semibold text-gray-800 capitalize">
                            {{ str_replace('_', ' ', $registration->job_title) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Job Function</p>
                        <p class="font-semibold text-gray-800 capitalize">
                            {{ str_replace('_', ' ', $registration->job_function) }}</p>
                    </div>
                </div>

                <hr class="mb-8 border-gray-200">

                {{-- Company Details --}}
                <h3 class="text-xl font-bold text-gray-900 mb-4">Company Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-8">
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Company Name</p>
                        <p class="font-semibold text-gray-800">{{ $registration->company_name }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-semibold text-gray-800">{{ $registration->address }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">City</p>
                        <p class="font-semibold text-gray-800">{{ $registration->city }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">State</p>
                        <p class="font-semibold text-gray-800">{{ $registration->state }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pincode</p>
                        <p class="font-semibold text-gray-800">{{ $registration->pincode }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Country</p>
                        <p class="font-semibold text-gray-800">{{ $registration->country }}</p>
                    </div>
                    @if ($registration->website)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Website</p>
                            <p class="font-semibold text-blue-600 break-all">{{ $registration->website }}</p>
                        </div>
                    @endif
                </div>

                <hr class="mb-8 border-gray-200">

                {{-- Business Details --}}
                <h3 class="text-xl font-bold text-gray-900 mb-4">Business Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-8">
                    <div>
                        <p class="text-sm text-gray-500">Industry Segment</p>
                        <p class="font-semibold text-gray-800 capitalize">{{ $registration->industry_segment }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nature of Business</p>
                        <p class="font-semibold text-gray-800 capitalize">{{ $registration->business_nature }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Primary Product Group</p>
                        <p class="font-semibold text-gray-800 capitalize">
                            {{ str_replace('_', ' ', $registration->primary_product_group) }}</p>
                    </div>
                    @if ($registration->additional_product_group)
                        <div>
                            <p class="text-sm text-gray-500">Additional Product Group</p>
                            <p class="font-semibold text-gray-800 capitalize">
                                {{ collect($registration->additional_product_group)->map(fn($g) => str_replace('_', ' ', $g))->join(', ') }}
                            </p>
                        </div>
                    @endif
                </div>

                <p class="text-sm text-gray-400 mb-8">
                    Registered on {{ $registration->created_at?->format('d M Y, h:i A') }}
                </p>

                {{-- Actions --}}
                {{-- <div class="flex flex-col md:flex-row gap-3">
                    <a href="{{ Route::has('registration.edit') ? route('registration.edit', $registration->id) : '#' }}"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 transition text-gray-800 font-bold py-3 rounded-xl">
                        ✏️ Edit Details
                    </a>
                    <button onclick="window.print()"
                        class="flex-1 text-center bg-red-600 hover:bg-red-700 transition text-white font-bold py-3 rounded-xl">
                        🖨️ Print Badge
                    </button>
                </div> --}}
                {{-- Actions --}}
                <div class="flex flex-col md:flex-row gap-3">
                    <a href="{{ Route::has('registration.edit') ? route('registration.edit', $registration->id) : '#' }}"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 transition text-gray-800 font-bold py-3 rounded-xl">
                        ✏️ Edit Details
                    </a>

                    <a href="{{ route('badge.download', $registration->registration_no) }}"
                        class="flex-1 text-center bg-red-600 hover:bg-red-700 transition text-white font-bold py-3 rounded-xl">
                        ⬇️ Download Badge
                    </a>

                    <button type="button" onclick="printBadge()"
                        class="flex-1 text-center bg-gray-800 hover:bg-gray-900 transition text-white font-bold py-3 rounded-xl">
                        🖨️ Print Badge
                    </button>
                </div>

                <script>
                    function printBadge() {
                        const badgeUrl = "{{ asset('storage/badge-cards/' . $registration->registration_no . '.png') }}";

                        const printWindow = window.open('', '_blank', 'width=500,height=650');

                        printWindow.document.write(`
                        <html>
                            <head>
                                <title>Badge</title>
                                <style>
                                    /* Paper size = actual badge size, no default page margins */
                                    @page {
                                        size: 2.5in 3in;
                                        margin: 0;
                                    }

                                    * {
                                        margin: 0;
                                        padding: 0;
                                        box-sizing: border-box;
                                    }

                                    html, body {
                                        width: 2.5in;
                                        height: 3in;
                                    }

                                    img {
                                        width: 2.5in;
                                        height: 3in;
                                        display: block;
                                    }
                                </style>
                            </head>
                            <body>
                                <img src="${badgeUrl}" onload="window.print(); window.onafterprint = () => window.close();">
                            </body>
                        </html>
                    `);

                        printWindow.document.close();
                    }
                </script>
            </div>
        </div>

        <p class="text-center text-gray-600 mt-6">
            <a href="{{ Route::has('registrations.find') ? route('registrations.find') : '#' }}"
                class="text-blue-600 font-semibold underline">Search another registration</a>
        </p>
    </div>

</body>

</html>
