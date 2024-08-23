<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActiveDaysConfiguration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ActiveDaysConfigurationController extends Controller
{
    public function showConfigurationForm()
    {
        if (Auth::check()) {
        $configuration = ActiveDaysConfiguration::first();
        $activeDays = $configuration ? $configuration->active_days : [];
        return view('admin.active_days_configuration', compact('activeDays'));
    } else {
        // Rediriger ou gérer les utilisateurs non connectés
        return redirect()->route('login');
    }

    }

    public function saveConfiguration(Request $request)
    {
        $request->validate([
            'active_days' => 'array|min:1',
        ]);

        $activeDays = $request->input('active_days');

        $configuration = ActiveDaysConfiguration::first();
        if ($configuration) {
            $configuration->update(['active_days' => $activeDays]);
        } else {
            ActiveDaysConfiguration::create(['active_days' => $activeDays]);
        }

        return redirect()->route('admin.active_days_configuration')->with('success', 'Configuration saved successfully!');
    }
}
