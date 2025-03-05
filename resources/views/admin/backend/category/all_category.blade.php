@extends('admin.admin_dashboard')
@section('admin')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="m-0">Toutes les catégories</h5>
                <a href="{{ route('add.category') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Ajouter une catégorie
                </a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom de la catégorie</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($categories as $key => $category)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>
                                <ul class="list-unstyled m-0 d-flex align-items-center">
                                    <li data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        class="avatar avatar-xs pull-up">
                                        <img src="{{ $category->category_image ? asset('storage/' . $category->category_image) : asset('default-image.jpg') }}"
                                             alt="Image catégorie"
                                             class="rounded-circle"
                                             style="width: 40px; height: 40px; object-fit: cover;"/>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <!-- Bouton Modifier -->
                                        <a class="dropdown-item" href="{{ route('edit.category', $category->id) }}">
                                            <i class="ti ti-pencil me-1"></i> Éditer
                                        </a>

                                        <!-- Bouton Supprimer (avec formulaire) -->
                                        <form method="POST" action="{{ route('delete.category', $category->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                                <i class="ti ti-trash me-1"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
