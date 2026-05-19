<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Normal bcrypt login (hlstats_Admins)
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Legacy MD5 fallback (hlstats_Users)
        $legacy = DB::table('hlstats_Users')
            ->where('username', $credentials['username'])
            ->first();

        if ($legacy && md5($credentials['password']) === $legacy->password) {
            $request->session()->put('admin_migrate_user', $legacy->username);
            return redirect()->route('admin.migrate-password');
        }

        return back()->withErrors(['username' => 'Identifiants invalides.'])->onlyInput('username');
    }

    public function showMigratePassword(Request $request)
    {
        if (! $request->session()->has('admin_migrate_user')) {
            return redirect()->route('admin.login');
        }

        return view('admin.migrate-password', [
            'username' => $request->session()->get('admin_migrate_user'),
        ]);
    }

    public function migratePassword(Request $request)
    {
        $username = $request->session()->get('admin_migrate_user');

        if (! $username) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'password'              => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $legacy = DB::table('hlstats_Users')->where('username', $username)->first();

        if (! $legacy) {
            return redirect()->route('admin.login');
        }

        $accessLevel = $legacy->acclevel >= 100 ? 'superadmin' : 'admin';

        DB::table('hlstats_Admins')->updateOrInsert(
            ['username' => $username],
            ['password' => Hash::make($request->password), 'accessLevel' => $accessLevel]
        );

        $request->session()->forget('admin_migrate_user');

        $admin = Admin::where('username', $username)->first();
        Auth::guard('admin')->login($admin);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
