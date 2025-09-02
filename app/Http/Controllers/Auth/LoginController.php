<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; // Pastikan use statement ini ada

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home'; // Baris ini tidak lagi kita perlukan

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect user to the correct dashboard based on their role.
     *
     * @return string
     */
    public function redirectTo()
    {
        $role = Auth::user()->role; 

        switch ($role) {
            case 'admin':
                return '/admin/dashboard';
                break; 
            case 'pelanggan':
                return '/dashboard-pelanggan';
                break;
            default:
                return '/login'; 
                break;
        }
    }
}

