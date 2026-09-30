<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Mail\RegistrationRegisteredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

class RegistrationController extends Controller

{
    private const BADGE_FOLDER = 'badge-cards/';

    public function getCreate()
    {
        return view('registrations.create');
    }

    public function postCreate(Request $request)
    {
        $validated = $request->validate([
            'email'                     => 'required|email|unique:registrations,email',
            'title'                     => 'required',
            'first_name'                => 'required|string|max:100',
            'last_name'                 => 'nullable|string|max:100',
            'gender'                    => 'nullable|string|max:100',
            'job_title'                 => 'required',
            'job_function'              => 'required',
            'phone'                     => 'required|max:10|unique:registrations,phone',
            'company_name'              => 'required',
            'address'                   => 'required',
            'country'                   => 'required',
            'pincode'                   => 'required',
            'state'                     => 'required',
            'city'                      => 'required',
            'website'                   => 'nullable',
            'industry_segment'          => 'required',
            'business_nature'           => 'required',
            'primary_product_group'     => 'required',
            'additional_product_group'   => 'nullable|array',
            'additional_product_group.*' => 'string|in:gifts,stationery,houseware,toys,other',
            'terms'                     => 'accepted',
            'agree_children_policy'     => 'accepted',
        ]);

        $validated['full_name'] = trim(
            $validated['first_name'].' '.($validated['last_name'] ?? '')
        );

        $validated['terms'] = $request->boolean('terms');
        $validated['agree_children_policy'] = $request->boolean('agree_children_policy');
        $validated['status'] = true;

        $validated['registration_no'] = 'TEMP';

        $registration = Registration::create($validated);

        $registration->update([
            'registration_no' => 'REG' . date('Y') . str_pad($registration->id, 5, '0', STR_PAD_LEFT),
        ]);

        $registration->refresh();

        $qrData = implode(PHP_EOL, [
            "Registration No : {$registration->registration_no}",
            "Visitor Name : {$registration->full_name}",
            "Company : {$registration->company_name}",
            "Email : {$registration->email}",
            "Phone : {$registration->phone}",
        ]);

        $result = new Builder(
            writer: new PngWriter(),
            data: $qrData,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: 500,
            margin: 20,
        );

        $qrImage = $result->build()->getString();

        $badgePath = $this->generateBadge(
            $registration,
            $qrImage
        );

        try {

            Mail::to($registration->email)
                ->send(new RegistrationRegisteredMail(
                    $registration,
                    $badgePath
                ));

        } catch (\Exception $e) {

            Log::error($e->getMessage());

        }

        return redirect()
            ->route('registration.create')
            ->with([
                'success' => 'Registration created successfully.',
                'badge' => asset(
                    'storage/' .
                    self::BADGE_FOLDER .
                    $registration->registration_no .
                    '.png'
                ),
            ]);
    }

    public function getFindBadge()
    {
        return view('registrations.find');
    }

    public function postFindBadge(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $search = $request->search;

        $registration = Registration::where('registration_no', $search)
            ->orWhere('email', $search)
            ->first();

        if (!$registration) {
            return back()
                ->withInput()
                ->with('error', 'Registration Number Or Email Not Found. Please try again.');
        }

        return redirect()->route('registrations.view', $registration->id);
    }

    public function getView($id)
    {
        $registration = Registration::findOrFail($id);

        return view('registrations.view',compact('registration'));
    }

    private function generateBadge($registration, $qrImage)
    {
        $cardWidth  = 750;
        $cardHeight = 900;

        $badge = imagecreatetruecolor($cardWidth, $cardHeight);

        $white  = imagecolorallocate($badge, 255, 255, 255);
        $black  = imagecolorallocate($badge, 0, 0, 0);
        $border = imagecolorallocate($badge, 210, 210, 210);

        imagefill($badge, 0, 0, $white);
        imagerectangle($badge, 0, 0, $cardWidth - 1, $cardHeight - 1, $border);

        $fontBold = public_path('fonts/Roboto-Bold.ttf');
        if (!file_exists($fontBold)) {
            throw new \Exception('Roboto-Bold.ttf not found.');
        }

        $edgeMargin   = 40;
        $maxTextWidth = $cardWidth - ($edgeMargin * 2);
        $gap          = 90; 

        $name = strtoupper($registration->full_name);
        $nameFont = $this->fitFontSize($name, $fontBold, $maxTextWidth, 90, 20);
        $nameHeight = $nameFont * 1.2;

        $qrSize = 400;

        $company = strtoupper($registration->company_name);
        $companyFont = 34;
        $companyLines = $this->wrapText($company, $fontBold, $companyFont, $maxTextWidth);
        $lineHeight = $companyFont * 1.3;
        $companyBlockHeight = count($companyLines) * $lineHeight;

        $totalHeight = $nameHeight + $gap + $qrSize + $gap + $companyBlockHeight;
        $topMargin = ($cardHeight - $totalHeight) / 2;

        $box = imagettfbbox($nameFont, 0, $fontBold, $name);
        $textWidth = $box[2] - $box[0];
        $x = ($cardWidth - $textWidth) / 2;
        $nameY = $topMargin + $nameFont;
        imagettftext($badge, $nameFont, 0, $x, $nameY, $black, $fontBold, $name);

        $qr = imagecreatefromstring($qrImage);

        if ($qr === false) {
            throw new \Exception('Unable to create QR image.');
        }

        $qrX = ($cardWidth - $qrSize) / 2;
        $qrY = $nameY + $gap;
        imagecopyresampled($badge, $qr, $qrX, $qrY, 0, 0, $qrSize, $qrSize, imagesx($qr), imagesy($qr));

        $lineY = $qrY + $qrSize + $gap + $companyFont;
        foreach ($companyLines as $line) {
            $box = imagettfbbox($companyFont, 0, $fontBold, $line);
            $textWidth = $box[2] - $box[0];
            $x = ($cardWidth - $textWidth) / 2;
            imagettftext($badge, $companyFont, 0, $x, $lineY, $black, $fontBold, $line);
            $lineY += $lineHeight;
        }

        $badgePath = storage_path(
            'app/public/' .
            config('badge.root') . '/' .
            config('badge.folders.visitor') . '/' .
            $registration->registration_no .
            '.png'
        );

        $folder = dirname($badgePath);

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        imagepng($badge, $badgePath);

        imagedestroy($badge);
        imagedestroy($qr);

        return $badgePath;
    }

    private function fitFontSize($text, $fontPath, $maxWidth, $startSize = 90, $minSize = 20)
    {
        for ($size = $startSize; $size >= $minSize; $size--) {
            $box = imagettfbbox($size, 0, $fontPath, $text);
            $width = $box[2] - $box[0];
            if ($width <= $maxWidth) {
                return $size;
            }
        }
        return $minSize;
    }

    private function wrapText($text, $fontPath, $fontSize, $maxWidth)
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine === '' ? $word : $currentLine . ' ' . $word;
            $box = imagettfbbox($fontSize, 0, $fontPath, $testLine);
            $width = $box[2] - $box[0];

            if ($width > $maxWidth && $currentLine !== '') {
                $lines[] = $currentLine;
                $currentLine = $word;
            } else {
                $currentLine = $testLine;
            }
        }

        if ($currentLine !== '') {
            $lines[] = $currentLine;
        }

        return $lines;
    }
}