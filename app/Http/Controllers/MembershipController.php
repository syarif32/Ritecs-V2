<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bank;
use App\Models\Transaction;
use App\Models\Membership;
use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MembershipCardSetting;
use Intervention\Image\Facades\Image;

class MembershipController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Membership aktif
        $membership = Membership::where('user_id', $user->user_id)
            ->where('end_date', '>=', Carbon::now()->toDateString())
            ->first();

        // Transaksi pending user
        $pending = Transaction::where('user_id', $user->user_id)
            ->where('status', 'pending')
            ->orderBy('created_at','desc')
            ->get();

        $banks = Bank::all();

        return view('profile.member', 
            ['title' => 'Membership'], 
            compact('user','membership','pending','banks')
        );
    }

    public function submitTransaction(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ✅ Validasi data diri + transaksi
        $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'nullable|string|max:100',
            'email'         => 'required|email|max:150|unique:users,email,' . $user->user_id . ',user_id',
            'nik'           => 'nullable|string|max:50',
            'birthday'      => 'nullable|date',
            'phone'         => 'nullable|string|max:50',
            'address'       => 'nullable|string',
            'city'          => 'nullable|string|max:255',
            'province'      => 'nullable|string|max:255',
            'institution'   => 'nullable|string|max:255',
            'ktp_path'      => $user->ktp_path ? 'nullable|image|mimes:jpg,jpeg,png|max:2048' : 'required|image|mimes:jpg,jpeg,png|max:2048',
            
            'sender_name'   => 'required|string|max:150',
            'sender_bank'   => 'required|string|max:100',
            'bank_id'       => 'nullable|exists:banks,bank_id',
            'amount'        => 'required|numeric|min:1',
            'proof'         => 'required|image|mimes:jpg,jpeg,png|max:3072',
            'type'          => 'required|in:firstPayments,extendedPayments',
        ]);

        // ✅ Update data user
        $user->first_name  = $request->first_name;
        $user->last_name   = $request->last_name;
        $user->email       = $request->email;
        $user->nik         = $request->nik;
        $user->birthday    = $request->birthday;
        $user->phone       = $request->phone;
        $user->address     = $request->address ?? '';
        $user->city        = $request->city ?? '';
        $user->province    = $request->province ?? '';
        $user->institution = $request->institution ?? '';

        // Upload KTP
        if ($request->hasFile('ktp_path')) {
            $filename = time().'_'.$request->file('ktp_path')->getClientOriginalName();
            $destination = public_assets_path('assets/users/identity');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            if ($user->ktp_path && file_exists(public_assets_path($user->ktp_path))) {
                @unlink(public_assets_path($user->ktp_path));
            }

            $request->file('ktp_path')->move($destination, $filename);
            $user->ktp_path = 'assets/users/identity/'.$filename;
        }

        $user->save();

        // ✅ Upload bukti transfer
        $filename = time().'_'.$request->file('proof')->getClientOriginalName();
        $destination = public_assets_path('assets/memberships/proofs');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $request->file('proof')->move($destination, $filename);
        $proofPath = 'assets/memberships/proofs/'.$filename;

        // ✅ Simpan transaksi
        Transaction::create([
            'user_id' => $user->user_id,
            'membership_id' => null,
            'amount' => $request->amount,
            'status' => 'pending',
            'proof_path' => $proofPath,
            'sender_name' => $request->sender_name,
            'sender_bank' => $request->sender_bank,
            'bank_id' => $request->bank_id,
            'type' => $request->type,
            'created_at' => now(),
        ]);

        return redirect()->route('profile.member')
            ->with('success','Transaksi berhasil dikirim. Menunggu verifikasi admin.');
    }
    public function submitTransactionApi(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            $request->validate([
                'first_name'  => 'required|string|max:100',
                'last_name'   => 'nullable|string|max:100',
                'email'       => 'required|email|max:150|unique:users,email,' . $user->user_id . ',user_id',
                'nik'         => 'nullable|string|max:50',
                'birthday'    => 'nullable|date',
                'phone'       => 'nullable|string|max:50',
                'address'     => 'nullable|string',
                'city'        => 'nullable|string|max:255',
                'province'    => 'nullable|string|max:255',
                'institution' => 'nullable|string|max:255',
                'ktp_path'    => $user->ktp_path ? 'nullable|image|max:2048' : 'required|image|max:2048',
                'sender_name' => 'required|string|max:150',
                'sender_bank' => 'required|string|max:100',
                'bank_id'     => 'required|exists:banks,bank_id',
                'amount'      => 'required|numeric',
                'proof'       => 'required|image|max:3072',
                'type'        => 'required|in:firstPayments,extendedPayments',
            ]);

            $user->first_name  = $request->first_name;
            $user->last_name   = $request->last_name;
            $user->email       = $request->email;
            $user->nik         = $request->nik;
            $user->birthday    = $request->birthday;
            $user->phone       = $request->phone;
            $user->address     = $request->address ?? '';
            $user->city        = $request->city ?? '';
            $user->province    = $request->province ?? '';
            $user->institution = $request->institution ?? '';

            if ($request->hasFile('ktp_path')) {
                $filename = time().'_ktp_'.$request->file('ktp_path')->getClientOriginalName();
                $destination = public_path('assets/users/identity'); 
                if (!file_exists($destination)) mkdir($destination, 0755, true);
                if ($user->ktp_path && file_exists(public_path($user->ktp_path))) {
                    @unlink(public_path($user->ktp_path));
                }
                $request->file('ktp_path')->move($destination, $filename);
                $user->ktp_path = 'assets/users/identity/'.$filename;
            }

            $user->save();

            $filenameProof = time().'_proof_'.$request->file('proof')->getClientOriginalName();
            $destinationProof = public_path('assets/memberships/proofs');
            if (!file_exists($destinationProof)) mkdir($destinationProof, 0755, true);
            $request->file('proof')->move($destinationProof, $filenameProof);
            $proofPath = 'assets/memberships/proofs/'.$filenameProof;

            \App\Models\Transaction::create([
                'user_id'     => $user->user_id,
                'amount'      => $request->amount,
                'status'      => 'pending',
                'proof_path'  => $proofPath,
                'sender_name' => $request->sender_name,
                'sender_bank' => $request->sender_bank,
                'bank_id'     => $request->bank_id,
                'type'        => $request->type,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran berhasil dikirim! Menunggu verifikasi admin.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid: ' . collect($e->errors())->flatten()->first()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('API Submit Transaction Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Generate & Return PNG Preview (untuk <img> tag di profile)
     */
    public function viewCard($id)
    {
        $membership = Membership::with('user')->findOrFail($id);
        $settings = MembershipCardSetting::getSettings();
        
        if (!$settings->front_image_path || !file_exists(public_assets_path($settings->front_image_path))) {
            abort(404, 'Front card image not found');
        }

        try {
            $img = Image::make(public_assets_path($settings->front_image_path));
            $gdImage = $img->getCore();
            $imageWidth = $img->width();
            $imageHeight = $img->height();
            
            // Get font path dengan prioritas
            $fontPath = $this->getFontPath($settings->name_font_file ?? $settings->font_file);
            $memberFontPath = $this->getFontPath($settings->member_number_font_file ?? $settings->font_file);
            $expiredFontPath = $this->getFontPath($settings->expired_date_font_file ?? $settings->font_file);
            
            // Add name
            if ($fontPath) {
                $namePos = $settings->name_position;
                $nameColor = $this->hex2rgb($namePos['color']);
                $nameTextColor = imagecolorallocate($gdImage, $nameColor[0], $nameColor[1], $nameColor[2]);
                $nameX = min($namePos['x'], $imageWidth - 50);
                $nameY = min($namePos['y'], $imageHeight - 20);
                imagettftext($gdImage, $namePos['font_size'], 0, $nameX, $nameY, $nameTextColor, $fontPath, $membership->user->full_name);
            }
            
            // Add member number
            if ($memberFontPath) {
                $memberPos = $settings->member_number_position;
                $memberColor = $this->hex2rgb($memberPos['color']);
                $memberTextColor = imagecolorallocate($gdImage, $memberColor[0], $memberColor[1], $memberColor[2]);
                $memberX = min($memberPos['x'], $imageWidth - 50);
                $memberY = min($memberPos['y'], $imageHeight - 20);
                imagettftext($gdImage, $memberPos['font_size'], 0, $memberX, $memberY, $memberTextColor, $memberFontPath, $membership->member_number);
            }
            
            // Add expired date
            if ($expiredFontPath) {
                $expiredPos = $settings->expired_date_position;
                $expiredDate = \Carbon\Carbon::parse($membership->end_date)->translatedFormat('d F Y');
                $expiredColor = $this->hex2rgb($expiredPos['color']);
                $expiredTextColor = imagecolorallocate($gdImage, $expiredColor[0], $expiredColor[1], $expiredColor[2]);
                $expiredX = min($expiredPos['x'], $imageWidth - 50);
                $expiredY = min($expiredPos['y'], $imageHeight - 10);
                imagettftext($gdImage, $expiredPos['font_size'], 0, $expiredX, $expiredY, $expiredTextColor, $expiredFontPath, 'Exp: ' . $expiredDate);
            }
            
            // Output PNG
            ob_start();
            imagepng($gdImage);
            $imageData = ob_get_clean();
            imagedestroy($gdImage);
            
            return response($imageData)->header('Content-Type', 'image/png');
            
        } catch (\Exception $e) {
            \Log::error('Error generating card preview: ' . $e->getMessage());
            abort(500, 'Failed to generate card preview');
        }
    }
    
    /**
     * Download PDF dengan kedua sisi kartu
     */
    public function downloadCard($id)
    {
        try {
            $membership = Membership::with('user')->findOrFail($id);
            $settings = MembershipCardSetting::getSettings();
            
            \Log::info('=== START DOWNLOAD CARD ===', [
                'membership_id' => $membership->membership_id,
                'user' => $membership->user->full_name,
                'front_image_path' => $settings->front_image_path ?? 'null',
                'back_image_path' => $settings->back_image_path ?? 'null'
            ]);
        
            // Generate front card
            $frontImage = null;
            if ($settings->front_image_path && file_exists(public_assets_path($settings->front_image_path))) {
                try {
                    \Log::info('Loading front image...');
                    
                    $img = Image::make(public_assets_path($settings->front_image_path));
                    $gdImage = $img->getCore();
                    $imageWidth = $img->width();
                    $imageHeight = $img->height();
                    
                    \Log::info('Image loaded successfully', [
                        'width' => $imageWidth,
                        'height' => $imageHeight
                    ]);
                    
                    // Get font paths
                    $nameFontPath = $this->getFontPath($settings->name_font_file ?? $settings->font_file);
                    $memberFontPath = $this->getFontPath($settings->member_number_font_file ?? $settings->font_file);
                    $expiredFontPath = $this->getFontPath($settings->expired_date_font_file ?? $settings->font_file);
                    
                    \Log::info('Font paths resolved', [
                        'name_font' => $nameFontPath ? basename($nameFontPath) : 'NOT FOUND',
                        'member_font' => $memberFontPath ? basename($memberFontPath) : 'NOT FOUND',
                        'expired_font' => $expiredFontPath ? basename($expiredFontPath) : 'NOT FOUND'
                    ]);
                    
                    // Add text to image
                    if ($nameFontPath) {
                        $namePos = $settings->name_position;
                        $nameColor = $this->hex2rgb($namePos['color']);
                        $nameTextColor = imagecolorallocate($gdImage, $nameColor[0], $nameColor[1], $nameColor[2]);
                        $nameX = min($namePos['x'], $imageWidth - 50);
                        $nameY = min($namePos['y'], $imageHeight - 20);
                        
                        $result = @imagettftext(
                            $gdImage, 
                            $namePos['font_size'], 
                            0, 
                            $nameX, 
                            $nameY, 
                            $nameTextColor, 
                            $nameFontPath, 
                            $membership->user->full_name
                        );
                        
                        if ($result === false) {
                            \Log::error('Failed to add name text');
                        } else {
                            \Log::info('Name text added successfully');
                        }
                    }
        
                    if ($memberFontPath) {
                        $memberPos = $settings->member_number_position;
                        $memberColor = $this->hex2rgb($memberPos['color']);
                        $memberTextColor = imagecolorallocate($gdImage, $memberColor[0], $memberColor[1], $memberColor[2]);
                        $memberX = min($memberPos['x'], $imageWidth - 50);
                        $memberY = min($memberPos['y'], $imageHeight - 20);
                        
                        $result = @imagettftext(
                            $gdImage, 
                            $memberPos['font_size'], 
                            0, 
                            $memberX, 
                            $memberY, 
                            $memberTextColor, 
                            $memberFontPath, 
                            $membership->member_number
                        );
                        
                        if ($result === false) {
                            \Log::error('Failed to add member number');
                        } else {
                            \Log::info('Member number added successfully');
                        }
                    }
        
                    if ($expiredFontPath) {
                        $expiredPos = $settings->expired_date_position;
                        $expiredDate = \Carbon\Carbon::parse($membership->end_date)->translatedFormat('d F Y');
                        $expiredColor = $this->hex2rgb($expiredPos['color']);
                        $expiredTextColor = imagecolorallocate($gdImage, $expiredColor[0], $expiredColor[1], $expiredColor[2]);
                        $expiredX = min($expiredPos['x'], $imageWidth - 50);
                        $expiredY = min($expiredPos['y'], $imageHeight - 10);
                        
                        $result = @imagettftext(
                            $gdImage, 
                            $expiredPos['font_size'], 
                            0, 
                            $expiredX, 
                            $expiredY, 
                            $expiredTextColor, 
                            $expiredFontPath, 
                            'Valid Until: ' . $expiredDate
                        );
                        
                        if ($result === false) {
                            \Log::error('Failed to add expiry date');
                        } else {
                            \Log::info('Expiry date added successfully');
                        }
                    }
        
                    // Convert ke PNG base64
                    ob_start();
                    $pngResult = imagepng($gdImage);
                    $imageData = ob_get_clean();
                    
                    if ($pngResult === false) {
                        throw new \Exception('Failed to generate PNG from GD image');
                    }
                    
                    $frontImage = 'data:image/png;base64,' . base64_encode($imageData);
                    imagedestroy($gdImage);
                    
                    \Log::info('Front card generated successfully', [
                        'image_size' => strlen($imageData) . ' bytes'
                    ]);
                    
                } catch (\Exception $e) {
                    \Log::error('Error generating front card', [
                        'error' => $e->getMessage(),
                        'line' => $e->getLine(),
                        'file' => $e->getFile()
                    ]);
                    
                    // Fallback: gunakan image asli tanpa text
                    $frontImage = 'data:image/png;base64,' . base64_encode(
                        file_get_contents(public_assets_path($settings->front_image_path))
                    );
                }
            } else {
                \Log::warning('Front image not found', [
                    'path' => $settings->front_image_path ?? 'null',
                    'exists' => $settings->front_image_path ? file_exists(public_assets_path($settings->front_image_path)) : false
                ]);
            }
        
            // Get back image
            $backImage = null;
            if ($settings->back_image_path && file_exists(public_assets_path($settings->back_image_path))) {
                try {
                    $backImage = 'data:image/png;base64,' . base64_encode(
                        file_get_contents(public_assets_path($settings->back_image_path))
                    );
                    \Log::info('Back card loaded successfully');
                } catch (\Exception $e) {
                    \Log::error('Error loading back card: ' . $e->getMessage());
                }
            }
            
            // Check if we have at least one image
            if (!$frontImage && !$backImage) {
                \Log::error('No card images available');
                return response()->json([
                    'error' => 'No card images configured. Please contact administrator.'
                ], 500);
            }
        
            // Generate PDF
            try {
                \Log::info('Generating PDF...');
                
                $pdf = Pdf::loadView('pdf.membership-card', [
                    'frontImage' => $frontImage,
                    'backImage' => $backImage,
                    'membership' => $membership
                ]);
            
                // KTP size: 85.6mm x 53.98mm → 242.65pt x 153.07pt
                $pdf->setPaper([0, 0, 242.65, 153.07], 'landscape');
                
                \Log::info('PDF generated successfully');
                \Log::info('=== END DOWNLOAD CARD ===');
                
                return $pdf->download('membership-card-' . $membership->member_number . '.pdf');
                
            } catch (\Exception $e) {
                \Log::error('PDF generation failed', [
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'error' => 'Failed to generate PDF: ' . $e->getMessage()
                ], 500);
            }
            
        } catch (\Exception $e) {
            \Log::error('Critical error in downloadCard', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'An error occurred while generating your membership card. Please try again later.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
    
    /**
     * Helper: Get font path dengan prioritas dan fallback
     */
    private function getFontPath($fontFilename)
    {
        $fontPaths = [];
        
        // 1. Custom font yang dipilih
        if ($fontFilename) {
            $fontPaths[] = public_assets_path('assets/memberships/fonts/' . $fontFilename);
        }
        
        // 2. Default font
        $fontPaths[] = public_assets_path('assets/memberships/fonts/Manrope-Bold.ttf');
        
        // 3. System fonts fallback
        $fontPaths[] = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';
        $fontPaths[] = '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf';
        $fontPaths[] = '/usr/share/fonts/dejavu/DejaVuSans-Bold.ttf';
        
        foreach ($fontPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        
        \Log::warning('No font file found, using fallback');
        return null;
    }
    
    /**
     * Helper: Convert hex color to RGB array
     */
    private function hex2rgb($hex) {
        $hex = str_replace('#', '', $hex);
        
        if (strlen($hex) == 3) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        
        return [$r, $g, $b];
    }
}