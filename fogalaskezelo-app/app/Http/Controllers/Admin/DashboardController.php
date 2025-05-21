<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard for the authenticated hairdresser.
     */
    public function __invoke(): View
    {
        $hairdresser = Auth::user()->hairdresser;

        return view('admin.dashboard', [
            'hairdresser' => $hairdresser,
            // ide később betölthetők statisztikák, értesítések stb.
        ]);
    }
}
