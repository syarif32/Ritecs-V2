<?php

namespace App\Http\Controllers\Admin\Frontend\Team;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Team\Team;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageTeamController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', [
            'team_pre_title',
            'team_title',
            'team_description'
        ])->pluck('value', 'key');

        $teams = Team::latest()->get();

        return view('backend.pages.team.index', [
            'title' => 'Kelola Halaman Tim',
            'settings' => $settings,
            'teams' => $teams,
        ]);
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'team_pre_title' => 'required|string|max:255',
            'team_title' => 'required|string|max:255',
            'team_description' => 'required|string',
        ]);

        Setting::updateOrCreate(['key' => 'team_pre_title'], ['value' => $request->team_pre_title]);
        Setting::updateOrCreate(['key' => 'team_title'], ['value' => $request->team_title]);
        Setting::updateOrCreate(['key' => 'team_description'], ['value' => $request->team_description]);

        return redirect()->back()->with('success', 'Judul & Deskripsi halaman tim berhasil diperbarui.');
    }

    public function storeTeam(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'img_path' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
        ]);

        $path = null;
        if ($request->hasFile('img_path')) {
          
            $path = $request->file('img_path')->store('teams', 'public');
        }

        Team::create(array_merge($request->all(), ['img_path' => $path]));

        return redirect()->back()->with('success', 'Anggota tim baru berhasil ditambahkan.');
    }

    public function updateTeam(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
        ]);

        $data = $request->except('img_path');

        if ($request->hasFile('img_path')) {
           
            if ($team->img_path) {
                Storage::disk('public')->delete($team->img_path);
            }
          
            $data['img_path'] = $request->file('img_path')->store('teams', 'public');
        }

        $team->update($data);

        return redirect()->back()->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    public function destroyTeam(Team $team)
    {
        if ($team->img_path) {
            Storage::disk('public')->delete($team->img_path);
        }
        $team->delete();

        return redirect()->back()->with('success', 'Anggota tim berhasil dihapus.');
    }
}
