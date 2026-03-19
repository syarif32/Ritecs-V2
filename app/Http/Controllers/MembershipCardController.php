<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipCardSetting;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class MembershipCardController extends Controller
{
    // Halaman settings untuk admin
   public function cardSettings()
    {
        try {
            $settings = MembershipCardSetting::getSettings();
            
            // Get list of available fonts
            $fonts = $this->getAvailableFonts();
            
            \Log::info('Fonts loaded:', ['count' => count($fonts)]);
            
            return view('backend.pages.membership-card-settings.card-settings', 
                compact('settings', 'fonts'), 
                ['title' => 'Membership Card Settings']
            );
        } catch (\Exception $e) {
            \Log::error('Error loading card settings: ' . $e->getMessage());
            
            // Fallback dengan empty fonts
            $settings = MembershipCardSetting::getSettings();
            $fonts = [];
            
            return view('backend.pages.membership-card-settings.card-settings', 
                compact('settings', 'fonts'), 
                ['title' => 'Membership Card Settings']
            )->with('error', 'Failed to load fonts: ' . $e->getMessage());
        }
    }

    // Get list of available fonts from folder
    private function getAvailableFonts()
    {
        try {
            $fontPath = public_assets_path('assets/memberships/fonts');
            
            \Log::info('Font path:', ['path' => $fontPath]);
            
            // Create folder if not exists
            if (!file_exists($fontPath)) {
                if (!mkdir($fontPath, 0755, true)) {
                    \Log::error('Failed to create fonts directory');
                    return [];
                }
            }
            
            $fonts = [];
            
            // Check if directory is readable
            if (!is_readable($fontPath)) {
                \Log::error('Fonts directory not readable');
                return [];
            }
            
            // Use File facade dengan error handling
            try {
                $files = File::files($fontPath);
            } catch (\Exception $e) {
                \Log::error('Error reading fonts directory: ' . $e->getMessage());
                return [];
            }
            
            foreach ($files as $file) {
                try {
                    $extension = strtolower($file->getExtension());
                    if (in_array($extension, ['ttf', 'otf'])) {
                        $fonts[] = [
                            'filename' => $file->getFilename(),
                            'name' => pathinfo($file->getFilename(), PATHINFO_FILENAME),
                            'size' => round($file->getSize() / 1024, 2), // KB
                            'path' => 'assets/memberships/fonts/' . $file->getFilename()
                        ];
                    }
                } catch (\Exception $e) {
                    \Log::warning('Error processing font file: ' . $e->getMessage());
                    continue;
                }
            }
            
            \Log::info('Fonts loaded successfully', ['count' => count($fonts)]);
            
            return $fonts;
            
        } catch (\Exception $e) {
            \Log::error('Critical error in getAvailableFonts: ' . $e->getMessage());
            return [];
        }
    }

    // Upload Font 
    public function uploadFont(Request $request)
    {
        try {
            \Log::info('Font upload request received', [
                'has_file' => $request->hasFile('font_file'),
                'file_size' => $request->file('font_file') ? $request->file('font_file')->getSize() : null
            ]);
            
            // ⭐ PERBAIKAN: Validasi yang lebih fleksibel untuk font files
            $request->validate([
                'font_file' => [
                    'required',
                    'file',
                    'max:5120', // max 5MB
                    function ($attribute, $value, $fail) {
                        // Custom validation: cek extension saja
                        $extension = strtolower($value->getClientOriginalExtension());
                        if (!in_array($extension, ['ttf', 'otf'])) {
                            $fail('The font file must be a TTF or OTF file.');
                        }
                        
                        // Optional: validasi MIME type juga (lebih aman)
                        $allowedMimes = [
                            'application/x-font-ttf',
                            'application/x-font-truetype',
                            'application/x-font-opentype',
                            'font/ttf',
                            'font/otf',
                            'font/opentype',
                            'application/octet-stream', // Fallback untuk beberapa server
                        ];
                        
                        $mime = $value->getMimeType();
                        \Log::info('Font MIME type detected: ' . $mime);
                        
                        // Jika MIME type tidak dikenali tapi extension benar, tetap izinkan
                        // (ini untuk handle server yang tidak properly detect font MIME types)
                    }
                ]
            ]);
    
            $destination = public_assets_path('assets/memberships/fonts');
            
            // Pastikan folder exists dan writable
            if (!file_exists($destination)) {
                if (!mkdir($destination, 0755, true)) {
                    throw new \Exception('Failed to create fonts directory');
                }
            }
            
            // Check if directory is writable
            if (!is_writable($destination)) {
                throw new \Exception('Fonts directory is not writable');
            }
    
            $file = $request->file('font_file');
            $filename = $file->getClientOriginalName();
            
            // Sanitize filename - hapus karakter special, tapi pertahankan extension
            $extension = strtolower($file->getClientOriginalExtension());
            $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $nameWithoutExt = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nameWithoutExt);
            $filename = $nameWithoutExt . '.' . $extension;
            
            \Log::info('Processing font upload', [
                'original_name' => $file->getClientOriginalName(),
                'sanitized_name' => $filename,
                'mime_type' => $file->getMimeType(),
                'destination' => $destination
            ]);
            
            // Check if file already exists
            if (file_exists($destination . '/' . $filename)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Font with this name already exists!'
                ], 422);
            }
    
            // Move file
            $file->move($destination, $filename);
            
            // Verify file was moved successfully
            if (!file_exists($destination . '/' . $filename)) {
                throw new \Exception('File was not saved successfully');
            }
            
            \Log::info('Font uploaded successfully', ['filename' => $filename]);
    
            return response()->json([
                'success' => true,
                'message' => 'Font uploaded successfully!',
                'font' => [
                    'filename' => $filename,
                    'name' => pathinfo($filename, PATHINFO_FILENAME),
                    'size' => round(filesize($destination . '/' . $filename) / 1024, 2)
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Font upload validation failed', ['errors' => $e->errors()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors()['font_file'] ?? ['Unknown error'])
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Font upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete font
    public function deleteFont(Request $request)
    {
        $filename = $request->input('filename');
        
        if (!$filename) {
            return response()->json([
                'success' => false,
                'message' => 'Filename is required'
            ], 422);
        }

        $filePath = public_assets_path('assets/memberships/fonts/' . $filename);
        
        if (!file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'Font file not found'
            ], 404);
        }

        // Prevent deleting system fonts
        $systemFonts = ['DejaVuSans-Bold.ttf', 'LiberationSans-Bold.ttf'];
        if (in_array($filename, $systemFonts)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete system font'
            ], 403);
        }

        if (@unlink($filePath)) {
            return response()->json([
                'success' => true,
                'message' => 'Font deleted successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete font'
        ], 500);
    }

    // Update settings
    public function updateCardSettings(Request $request)
    {
        $request->validate([
            'front_image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'back_image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'font_file' => 'nullable|string|max:255', // nama file font yang dipilih
            'name_x' => 'required|numeric',
            'name_y' => 'required|numeric',
            'name_font_size' => 'required|numeric|min:12|max:100',
            'name_color' => 'required|string',
            'member_number_x' => 'required|numeric',
            'member_number_y' => 'required|numeric',
            'member_number_font_size' => 'required|numeric|min:12|max:100',
            'member_number_color' => 'required|string',
            'expired_x' => 'required|numeric',
            'expired_y' => 'required|numeric',
            'expired_font_size' => 'required|numeric|min:12|max:100',
            'expired_color' => 'required|string',
        ]);

        $settings = MembershipCardSetting::getSettings();

        // Upload front image
        if ($request->hasFile('front_image')) {
            $destination = public_assets_path('assets/memberships/templates');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            if ($settings->front_image_path && file_exists(public_assets_path($settings->front_image_path))) {
                @unlink(public_assets_path($settings->front_image_path));
            }

            $filename = 'card_front_' . time() . '.' . $request->file('front_image')->getClientOriginalExtension();
            $request->file('front_image')->move($destination, $filename);
            $settings->front_image_path = 'assets/memberships/templates/' . $filename;
        }

        // Upload back image
        if ($request->hasFile('back_image')) {
            $destination = public_assets_path('assets/memberships/templates');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            if ($settings->back_image_path && file_exists(public_assets_path($settings->back_image_path))) {
                @unlink(public_assets_path($settings->back_image_path));
            }

            $filename = 'card_back_' . time() . '.' . $request->file('back_image')->getClientOriginalExtension();
            $request->file('back_image')->move($destination, $filename);
            $settings->back_image_path = 'assets/memberships/templates/' . $filename;
        }

        // Update text positions
        $settings->name_position = [
            'x' => $request->name_x,
            'y' => $request->name_y,
            'font_size' => $request->name_font_size,
            'color' => $request->name_color
        ];

        $settings->member_number_position = [
            'x' => $request->member_number_x,
            'y' => $request->member_number_y,
            'font_size' => $request->member_number_font_size,
            'color' => $request->member_number_color
        ];

        $settings->expired_date_position = [
            'x' => $request->expired_x,
            'y' => $request->expired_y,
            'font_size' => $request->expired_font_size,
            'color' => $request->expired_color
        ];

        // Save selected font
        if ($request->filled('font_file')) {
            $settings->font_file = $request->font_file;
        }

        $settings->save();

        return redirect()->route('admin.membership-card-settings')
            ->with('success', 'Membership card settings updated successfully!');
    }

    // Generate preview (AJAX)
    public function generatePreview(Request $request)
    {
        $settings = MembershipCardSetting::getSettings();
        
        if (!$settings->front_image_path || !file_exists(public_assets_path($settings->front_image_path))) {
            return response()->json(['error' => 'Front image not found'], 404);
        }
    
        // Sample data
        $name = $request->input('name', 'Anur Mustakim');
        $memberNumber = $request->input('member_number', '01.2025.00001');
        $expiredDate = $request->input('expired_date', '31 Dec 2026');
    
        // Override with request positions if provided
        $namePos = [
            'x' => $request->input('name_x', $settings->name_position['x']),
            'y' => $request->input('name_y', $settings->name_position['y']),
            'font_size' => $request->input('name_font_size', $settings->name_position['font_size']),
            'color' => $request->input('name_color', $settings->name_position['color'])
        ];
    
        $memberPos = [
            'x' => $request->input('member_number_x', $settings->member_number_position['x']),
            'y' => $request->input('member_number_y', $settings->member_number_position['y']),
            'font_size' => $request->input('member_number_font_size', $settings->member_number_position['font_size']),
            'color' => $request->input('member_number_color', $settings->member_number_position['color'])
        ];
    
        $expiredPos = [
            'x' => $request->input('expired_x', $settings->expired_date_position['x']),
            'y' => $request->input('expired_y', $settings->expired_date_position['y']),
            'font_size' => $request->input('expired_font_size', $settings->expired_date_position['font_size']),
            'color' => $request->input('expired_color', $settings->expired_date_position['color'])
        ];
    
        try {
            $img = Image::make(public_assets_path($settings->front_image_path));
            $gdImage = $img->getCore();
            $imageWidth = $img->width();
            $imageHeight = $img->height();
            
            // Get selected font dari request atau settings
            $selectedFont = $request->input('font_file', $settings->font_file ?? null);
            
            // Build font paths dengan prioritas
            $fontPaths = [];
            
            // 1. Font yang dipilih user
            if ($selectedFont) {
                $fontPaths[] = public_assets_path('assets/memberships/fonts/' . $selectedFont);
            }
            
            // 2. Font default di folder fonts
            $fontPaths[] = public_assets_path('assets/memberships/fonts/Manrope-Bold.ttf');
            
            // 3. System fonts sebagai fallback
            $fontPaths[] = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';
            $fontPaths[] = '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf';
            
            $fontPath = null;
            foreach ($fontPaths as $path) {
                if (file_exists($path)) {
                    $fontPath = $path;
                    break;
                }
            }
            
            if ($fontPath) {
                // Add name
                $nameColor = $this->hex2rgb($namePos['color']);
                $nameTextColor = imagecolorallocate($gdImage, $nameColor[0], $nameColor[1], $nameColor[2]);
                $nameX = min($namePos['x'], $imageWidth - 50);
                $nameY = min($namePos['y'], $imageHeight - 20);
                imagettftext($gdImage, $namePos['font_size'], 0, $nameX, $nameY, $nameTextColor, $fontPath, $name);
                
                // Add member number
                $memberColor = $this->hex2rgb($memberPos['color']);
                $memberTextColor = imagecolorallocate($gdImage, $memberColor[0], $memberColor[1], $memberColor[2]);
                $memberX = min($memberPos['x'], $imageWidth - 50);
                $memberY = min($memberPos['y'], $imageHeight - 20);
                imagettftext($gdImage, $memberPos['font_size'], 0, $memberX, $memberY, $memberTextColor, $fontPath, $memberNumber);
                
                // Add expired date
                $expiredColor = $this->hex2rgb($expiredPos['color']);
                $expiredTextColor = imagecolorallocate($gdImage, $expiredColor[0], $expiredColor[1], $expiredColor[2]);
                $expiredX = min($expiredPos['x'], $imageWidth - 50);
                $expiredY = min($expiredPos['y'], $imageHeight - 10);
                imagettftext($gdImage, $expiredPos['font_size'], 0, $expiredX, $expiredY, $expiredTextColor, $fontPath, 'Valid Until: ' . $expiredDate);
            } else {
                // Fallback ke imagestring
                $nameColor = $this->hex2rgb($namePos['color']);
                $nameTextColor = imagecolorallocate($gdImage, $nameColor[0], $nameColor[1], $nameColor[2]);
                imagestring($gdImage, 5, $namePos['x'], $namePos['y'], $name, $nameTextColor);
                
                $memberColor = $this->hex2rgb($memberPos['color']);
                $memberTextColor = imagecolorallocate($gdImage, $memberColor[0], $memberColor[1], $memberColor[2]);
                imagestring($gdImage, 4, $memberPos['x'], $memberPos['y'], $memberNumber, $memberTextColor);
                
                $expiredColor = $this->hex2rgb($expiredPos['color']);
                $expiredTextColor = imagecolorallocate($gdImage, $expiredColor[0], $expiredColor[1], $expiredColor[2]);
                imagestring($gdImage, 3, $expiredPos['x'], $expiredPos['y'], 'Valid Until: ' . $expiredDate, $expiredTextColor);
            }
            
            ob_start();
            imagepng($gdImage);
            $imageData = ob_get_clean();
            imagedestroy($gdImage);
            
            $base64 = 'data:image/png;base64,' . base64_encode($imageData);
            
            return response()->json(['image' => $base64]);
            
        } catch (\Exception $e) {
            \Log::error('Preview generation error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
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