<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentLog;

class ContentLogController extends Controller
{
    public function index()
    {
        
        $logs = ContentLog::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.pages.logs.content-history', compact('logs'), [
            'title' => 'Content Upload History'
        ]);
    }
}