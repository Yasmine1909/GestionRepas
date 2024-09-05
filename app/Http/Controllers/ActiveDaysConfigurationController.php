<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActiveDaysConfiguration;
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
        // Si aucun jour n'est coché, rediriger avec un message d'erreur
        if (!$request->has('active_days')) {
            return redirect()->route('admin.active_days_configuration')->with('error', 'Veuillez sélectionner au moins un jour.');
        }

        $activeDays = $request->input('active_days');

        $configuration = ActiveDaysConfiguration::first();
        if ($configuration) {
            $configuration->update(['active_days' => $activeDays]);
        } else {
            ActiveDaysConfiguration::create(['active_days' => $activeDays]);
        }

        return redirect()->route('admin.active_days_configuration')->with('success', 'La configuration a été enregistrée avec succès !');
    }
}
