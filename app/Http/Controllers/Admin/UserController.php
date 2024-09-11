<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\UsersImport;

class UserController extends Controller
{
    public function importUsers(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'users_excel' => 'required|mimes:xlsx,xls',
        ]);

        // Import users from the uploaded Excel file
        try {
            $filePath = $request->file('users_excel')->getRealPath();
            $importer = new UsersImport();
            $importer->import($filePath);

            return back()->with('success', 'Les utilisateurs ont été importés et leurs informations récupérées depuis LDAP.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'importation : ' . $e->getMessage());
        }
    }
}
