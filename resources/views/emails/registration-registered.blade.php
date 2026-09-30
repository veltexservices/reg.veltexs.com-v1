<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: Arial, sans-serif; background: #f4f4f7; padding: 30px 0; margin: 0;">
    <div
        style="max-width: 500px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">

        {{-- Header --}}
        <div style="background: linear-gradient(90deg, #dc2626, #b91c1c); padding: 24px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 20px;">Registration Confirmed 🎉</h1>
            <p style="color: #fecaca; margin: 6px 0 0; font-size: 13px;">{{ $event->name ?? 'Gifts World Expo - Delhi' }}
            </p>
        </div>

        {{-- Greeting --}}
        <div style="padding: 24px 24px 0;">
            <p style="font-size: 15px; color: #374151;">Dear
                <strong>{{ $registration->full_name ?? trim(($registration->first_name ?? '') . ' ' . ($registration->last_name ?? '')) }}</strong>,
            </p>

            <p style="font-size: 14px; color: #6b7280; line-height: 1.6;">
                Thank you for registering for {{ $event->name ?? 'Gifts World Expo - Delhi' }}! Your visitor badge is
                ready.
                Please present the QR code below at the Registration Counter to collect your printed entry badge.
            </p>
        </div>

        <div style="padding:20px;text-align:center;">

            <img src="{{ $message->embed($badgePath) }}" alt="Visitor Badge" style="width:100%;max-width:700px;">

        </div>

        {{-- Registration Details --}}
        <div style="padding: 0 24px 24px;">
            <table style="width: 100%; font-size: 14px; color: #374151; margin: 0 0 16px; border-collapse: collapse;">
                <tr>
                    <td style="padding: 6px 0; color: #9ca3af;">Registration No.</td>
                    <td style="padding: 6px 0; text-align: right; font-weight: 600;">
                        {{ $registration->registration_no }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #9ca3af;">Company</td>
                    <td style="padding: 6px 0; text-align: right; font-weight: 600;">{{ $registration->company_name }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #9ca3af;">Email</td>
                    <td style="padding: 6px 0; text-align: right; font-weight: 600;">{{ $registration->email }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #9ca3af;">Phone</td>
                    <td style="padding: 6px 0; text-align: right; font-weight: 600;">{{ $registration->phone }}</td>
                </tr>
            </table>

            <p style="font-size: 13px; color: #9ca3af; line-height: 1.6;">
                Please keep this QR code safe — mobile badges/soft copies are acceptable for entry at the Registration
                Counter,
                but must be clearly scannable. Entry is restricted to business and trade visitors only.
                Children below 16 years of age are strictly not allowed inside the halls.
            </p>
        </div>

        {{-- Footer --}}
        <div style="background: #f9fafb; padding: 16px; text-align: center; font-size: 12px; color: #9ca3af;">
            &copy; {{ date('Y') }} {{ $event->name ?? 'Gifts World Expo Delhi' }}. All rights reserved.
        </div>
    </div>
</body>

</html>
