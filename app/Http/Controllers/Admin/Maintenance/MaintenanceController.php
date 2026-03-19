<?php

namespace App\Http\Controllers\Admin\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File; 

class MaintenanceController extends Controller
{
    /**
     * 
     * @param string $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache($type)
    {
        $message = '';
        try {
            switch ($type) {
                case 'config':
                    Artisan::call('config:clear');
                    $message = 'Cache konfigurasi berhasil dibersihkan.';
                    break;
                case 'route':
                    Artisan::call('route:clear');
                    $message = 'Cache rute berhasil dibersihkan.';
                    break;
                case 'view':
                    Artisan::call('view:clear');
                    $message = 'Cache view berhasil dibersihkan.';
                    break;
                case 'optimize':
                    Artisan::call('optimize:clear');
                    $message = 'Semua cache berhasil dibersihkan.';
                    break;
                case 'rebuild':
                    Artisan::call('optimize');
                    Artisan::call('route:clear');
                    return redirect()->route('admin.maintenance.index', ['rebuild_status' => 'success']);

                default:
                   
                    return back()->with('error', 'Perintah maintenance tidak valid.');
            }
            
            return redirect()->route('admin.maintenance.index')->with('success', $message);

        } catch (\Exception $e) {
            
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * 
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearLogs()
    {
       
        $logPath = storage_path('logs');
        $files = File::glob($logPath . '/*.log');

        foreach ($files as $file) {
            File::delete($file); 
        }

        return back()->with('success', 'Semua file log berhasil dihapus!');
    }
}

