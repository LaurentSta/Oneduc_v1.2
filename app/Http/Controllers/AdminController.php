<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Affiche la page de connexion, sauf si l'utilisateur est déjà connecté.
     */
    public function Login()
    {
        if (Auth::check()) {
            return redirect()->route($this->redirectUserByRole()); // Redirige un utilisateur connecté
        }

        return view('frontend.dashboard.login');
    }

    /**
     * Redirige un utilisateur après connexion en fonction de son rôle.
     */
    private function redirectUserByRole()
    {
        return match (Auth::user()->role) {
            'admin' => 'admin.dashboard',      // Redirige les administrateurs
            'instructor' => 'instructor.dashboard', // Redirige les instructeurs
            default => 'dashboard',           // Redirige les utilisateurs classiques
        };
    }

    /**
     * Redirection après connexion
     */
    protected function authenticated()
    {
        return redirect()->route($this->redirectUserByRole());
    }

    public function AdminDashboard()
    {
        return view('admin.index');
    }

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/connexion');
    }

    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));
    }

    public function AdminParametre()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_parametre', compact('profileData'));
    }

    public function AdminProfilStore(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        $user->name = $request->lastName;
        $user->username = $request->firstName;
        $user->email = $request->email;
        $user->phone = $request->phoneNumber;

        // Gestion de l'upload de l'image
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('/upload/admin_images'), $filename);
            $user->photo = $filename;
        }

        $user->save();

        return redirect()->route('admin.parametre')->with('message', 'Profil mis à jour avec succès.');
    }

    public function showAdminSecurite()
    {
        $user = Auth::user(); // Récupérer les données de l'utilisateur
        return view('admin.admin_securite', compact('user')); // Afficher la vue
    }

    public function AdminSecurite(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id); // Récupère l'utilisateur depuis la base de données

        // Validation des champs
        $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed',
        ]);

        // Vérifier si le mot de passe actuel est correct
        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->with('error', 'Le mot de passe actuel est incorrect.');
        }

        // Mettre à jour le mot de passe
        $user->password = Hash::make($request->newPassword);
        $user->save(); // Sauvegarde dans la base de données

        return back()->with('message', 'Votre mot de passe a été modifié avec succès.');
    }
}
