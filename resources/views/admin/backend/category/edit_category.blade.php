@extends('admin.admin_dashboard')
@section('admin')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="m-0">Modifier la catégorie</h5>
                <a href="{{ route('all.category') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Retour
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('update.category') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $category->id }}">

                    <!-- Nom de la catégorie -->
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Nom de la catégorie</label>
                        <input type="text" name="category_name" id="category_name" class="form-control @error('category_name') is-invalid @enderror"
                               value="{{ old('category_name', $category->category_name) }}" required>
                        @error('category_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Image actuelle -->
                    <div class="mb-3">
                        <label class="form-label d-block">Image actuelle</label>
                        <img src="{{ asset('storage/' . $category->category_image) }}" alt="Image catégorie"
                             class="rounded border" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>

                    <!-- Nouvelle image -->
                    <div class="mb-3">
                        <label for="category_image" class="form-label">Nouvelle image (optionnel)</label>
                        <input type="file" name="category_image" id="category_image" class="form-control @error('category_image') is-invalid @enderror">
                        @error('category_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Bouton de mise à jour -->
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-check"></i> Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
