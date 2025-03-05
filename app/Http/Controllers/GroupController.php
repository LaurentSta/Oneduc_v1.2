<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Models\User;

class GroupController extends Controller
{
    // 🟢 Voir tous les groupes
    public function AllGroup()
    {
        $groupes = Groupe::all();
        return view('admin.backend.groupes.all_groupes', compact('groupes'));
    }

    // 🟢 Afficher le formulaire de création
    public function AddGroup()
    {
        return view('admin.backend.groupes.add_groupe');
    }

    // 🟢 Enregistrer un groupe
    public function StoreGroup(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:groupes',
        ]);

        Groupe::create(['nom' => $request->nom]);

        return redirect()->route('all.group')->with('success', 'Groupe créé avec succès');
    }

    // 🟢 Modifier un groupe
    public function EditGroup($id)
    {
        $groupe = Groupe::findOrFail($id);
        return view('admin.backend.groupes.edit_groupe', compact('groupe'));
    }

    // 🟢 Mettre à jour un groupe
    public function UpdateGroup(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:groupes,nom,' . $id,
        ]);

        $groupe = Groupe::findOrFail($id);
        $groupe->update(['nom' => $request->nom]);

        return redirect()->route('all.group')->with('success', 'Groupe mis à jour');
    }

    // 🟢 Supprimer un groupe
    public function DeleteGroup($id)
    {
        $groupe = Groupe::findOrFail($id);
        $groupe->delete();
        return redirect()->route('all.group')->with('success', 'Groupe supprimé');
    }

    // 🟢 Afficher l’interface d’assignation des stagiaires
    public function AssignStagiaires($id)
    {
        $groupe = Groupe::findOrFail($id);
        $stagiaires = User::where('role', 'stagiaire')->get();
        return view('admin.backend.groupes.assign_stagiaires', compact('groupe', 'stagiaires'));
    }

    // 🟢 Assigner des stagiaires à un groupe
    public function StoreStagiaires(Request $request, $id)
    {
        $groupe = Groupe::findOrFail($id);

        $request->validate([
            'stagiaires' => 'array',
        ]);

        $groupe->stagiaires()->sync($request->stagiaires);

        return redirect()->route('all.group')->with('success', 'Stagiaires assignés au groupe.');
    }
}
