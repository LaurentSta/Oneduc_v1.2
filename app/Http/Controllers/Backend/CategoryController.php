<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Afficher toutes les catégories
    public function AllCategory()
    {
        $categories = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('categories'));
    }

    // Afficher le formulaire d'ajout
    public function AddCategory()
    {
        return view('admin.backend.category.add_category');
    }

    // Enregistrer une nouvelle catégorie
    public function StoreCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $imagePath = $request->file('category_image')->store('category_images', 'public');

            Category::create([
                'category_name' => $request->category_name,
                'category_slug' => Str::slug($request->category_name),
                'category_image' => $imagePath
            ]);

            return redirect()->route('all.category')->with('success', 'Catégorie ajoutée avec succès 🎉');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la catégorie');
        }
    }

    // Afficher le formulaire d'édition
    public function EditCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.backend.category.edit_category', compact('category'));
    }

    // Mettre à jour une catégorie
    public function UpdateCategory(Request $request)
    {
        $category = Category::findOrFail($request->id);

        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $category->id,
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $data = [
                'category_name' => $request->category_name,
                'category_slug' => Str::slug($request->category_name),
            ];

            if ($request->hasFile('category_image')) {
                if (Storage::disk('public')->exists($category->category_image)) {
                    Storage::disk('public')->delete($category->category_image);
                }
                $data['category_image'] = $request->file('category_image')->store('category_images', 'public');
            }

            $category->update($data);

            return redirect()->route('all.category')->with('success', 'Catégorie mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la catégorie');
        }
    }

    // Supprimer une catégorie
    public function DeleteCategory($id)
    {
        try {
            $category = Category::findOrFail($id);

            if (Storage::disk('public')->exists($category->category_image)) {
                Storage::disk('public')->delete($category->category_image);
            }

            $category->delete();

            return redirect()->back()->with('success', 'Catégorie supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression de la catégorie');
        }
    }
}
