<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        return match ($user->role) {
            'superadmin' => view('dashboard.superadmin'),
            'manager' => view('dashboard.manager'),
            'accountant' => view('dashboard.accountant'),
            'landlord' => view('dashboard.landlord'),
            'school_admin' => view('dashboard.school_admin'),
            'hostel_warden' => view('dashboard.hostel_warden'),
            'tenant' => view('dashboard.tenant'),
            default => view('dashboard.tenant'), // Fallback to tenant
        };
    }
}
