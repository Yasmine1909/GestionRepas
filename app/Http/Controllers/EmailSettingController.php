<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailSetting;

class EmailSettingController extends Controller
{
    public function edit()
    {
         $emailSetting = EmailSetting::first() ?? EmailSetting::create(['enabled' => false]);

        // Assurez-vous que la vue 'admin.active_days_configuration' reçoit la variable $emailSetting
        return view('admin.active_days_configuration', compact('emailSetting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email_setting' => 'required|boolean',
        ]);

        // Obtenez la première configuration ou créez-en une par défaut
        $emailSetting = EmailSetting::first() ?? EmailSetting::create(['enabled' => false]);
        $emailSetting->enabled = $request->input('email_setting');
        $emailSetting->save();

        return redirect()->back()->with('success', 'Configuration mise à jour avec succès.');
    }
}
