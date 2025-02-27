<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Index(){
        return view('frontend.index');
    }
    public function Register()
    {
        return view('frontend.dashboard.register'); // Vérifie que ce fichier existe
    }
    public function Projet()
    {
        return view('frontend.contenu.projet');
    }
    public function Association()
    {
        return view('frontend.contenu.association');
    }
    public function Adhesion()
    {
        return view('frontend.contenu.adhesion');
    }
}
