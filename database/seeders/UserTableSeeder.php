<?php

namespace Database\Seeders;

// Importation des classes nécessaires pour le seeder
use Illuminate\Database\Console\Seeds\WithoutModelEvents; // (Optionnel) Utilisé pour exclure certains événements de modèles lors de l'exécution des seeders
use Illuminate\Database\Seeder; // Classe de base pour tous les seeders
use Illuminate\Support\Facades\Auth; // Façade Auth pour l'authentification (non utilisé ici mais peut être utile pour d'autres seeders)
use Illuminate\Support\Facades\Hash; // Façade Hash pour le hachage des mots de passe
use DB; // Façade DB pour interagir avec la base de données en utilisant le Query Builder

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Cette méthode est appelée lorsqu'on exécute le seeder.
     */
    public function run(): void
    {
        // Utilisation de la façade DB pour insérer des enregistrements dans la table 'users'
        DB::table('users')->insert([

            // Insertion d'un utilisateur Admin
            [
                'name' => 'Admin', // Nom de l'utilisateur
                'username' => 'admin', // Nom d'utilisateur
                'email' => 'admin@gmail.com', // Email de l'utilisateur
                'password' => Hash::make('111'), // Mot de passe haché pour des raisons de sécurité
                'role' => 'admin', // Rôle de l'utilisateur (admin)
                'status' => '1', // Statut de l'utilisateur (1 = actif, 0 = inactif par exemple)
            ],

            // Insertion d'un utilisateur Instructor
            [
                'name' => 'Instructor', // Nom de l'utilisateur
                'username' => 'instructor', // Nom d'utilisateur
                'email' => 'instructor@gmail.com', // Email de l'utilisateur
                'password' => Hash::make('111'), // Mot de passe haché
                'role' => 'instructor', // Rôle de l'utilisateur (instructeur)
                'status' => '1', // Statut de l'utilisateur (1 = actif)
            ],

            // Insertion d'un utilisateur régulier
            [
                'name' => 'User', // Nom de l'utilisateur
                'username' => 'user', // Nom d'utilisateur
                'email' => 'user@gmail.com', // Email de l'utilisateur
                'password' => Hash::make('111'), // Mot de passe haché
                'role' => 'user', // Rôle de l'utilisateur (utilisateur régulier)
                'status' => '1', // Statut de l'utilisateur (1 = actif)
            ],

        ]);
    }
}

