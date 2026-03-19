<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{

    public function dashboard()
    {
        return view('backend.pages.dashboard', ['title' => 'Dashboard']);
    }
    public function index()
    {
        // 
    }

    public function assignMemberRole(Request $request, User $user)
    {
        //
    }
}