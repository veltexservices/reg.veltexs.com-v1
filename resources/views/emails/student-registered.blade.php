<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f7; padding: 30px 0; margin: 0;">
    <div style="max-width: 500px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">

        <div style="background: linear-gradient(90deg, #6366f1, #4f46e5); padding: 24px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 20px;">Registration Successful 🎉</h1>
        </div>

        <div style="padding: 24px;">
            <p style="font-size: 15px; color: #374151;">Dear <strong>{{ $student->full_name }}</strong>,</p>

            <p style="font-size: 14px; color: #6b7280; line-height: 1.6;">
                Thank you for registering with us! Your student profile has been created successfully.
                Below are your registration details:
            </p>

            <table style="width: 100%; font-size: 14px; color: #374151; margin: 16px 0; border-collapse: collapse;">
                <tr>
                    <td style="padding: 6px 0; color: #9ca3af;">Student ID</td>
                    <td style="padding: 6px 0; text-align: right; font-weight: 600;">{{ $student->student_id }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #9ca3af;">Course</td>
                    <td style="padding: 6px 0; text-align: right; font-weight: 600;">{{ $student->course }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #9ca3af;">Roll Number</td>
                    <td style="padding: 6px 0; text-align: right; font-weight: 600;">{{ $student->roll_number }}</td>
                </tr>
            </table>

            <div style="text-align: center; margin: 24px 0; padding: 16px; background: #f9fafb; border-radius: 10px;">
                <p style="font-size: 13px; color: #6b7280; margin-bottom: 10px;">Your unique QR Code (attached below)</p>
                <img src="cid:qrcode" alt="Student QR Code" style="width: 180px; height: 180px;">
            </div>

            <p style="font-size: 13px; color: #9ca3af; line-height: 1.6;">
                Please keep this QR code safe — it will be used for identification and verification purposes
                on campus.
            </p>
        </div>

        <div style="background: #f9fafb; padding: 16px; text-align: center; font-size: 12px; color: #9ca3af;">
            &copy; {{ date('Y') }} Your Institute Name. All rights reserved.
        </div>
    </div>
</body>
</html>