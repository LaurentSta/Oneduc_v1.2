@extends('admin.admin_dashboard')
@section('admin')
<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <h5 class="card-header">Modifier la Catégorie</h5>
            <form class="card-body" method="POST" action="{{ route('update.category') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Indiquer à Laravel que c'est une mise à jour -->

                <!-- Champ caché pour l'ID -->
                <input type="hidden" name="id" value="{{ $category->id }}">

                <h6>1. Détails de la Catégorie</h6>
                <div class="row g-3">
                    <!-- Nom de la catégorie -->
                    <div class="col-md-4">
                        <label class="form-label" for="category_name">Nom de la Catégorie</label>
                        <input type="text" name="category_name" id="category_name" class="form-control"
                               value="{{ $category->category_name }}" required>
                    </div>

                    <!-- Image de prévisualisation -->
                    <div class="col-md-8">
                        <img id="preview-image" src="{{ asset('storage/' . $category->category_image) }}"
                             alt="Aperçu" class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img"
                             style="max-width: 150px; max-height: 150px; object-fit: cover;">
                    </div>

                    <!-- Champ d'upload d'image -->
                    <div class="col-md-8">
                        <label class="form-label" for="category-image">Image</label>
                        <input type="file" class="form-control" name="category_image" id="category-image" accept="image/*">
                    </div>
                </div>

                <div class="pt-3">
                    <button type="submit" class="btn btn-primary me-4 waves-effect waves-light">Mettre à jour</button>
                    <button type="reset" class="btn btn-label-secondary waves-effect">Annuler</button>
                </div>
            </form>

            <!-- Script pour l'aperçu de l'image -->
            <script>
            document.getElementById('category-image').addEventListener('change', function(event) {
                let reader = new FileReader();
                reader.onload = function() {
                    document.getElementById('preview-image').src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            });
            </script>
        </div>
    </div>
</div>

<!-- Toastr pour afficher les messages -->
@if(session('success'))
    <script>
        $(document).ready(function() {
            toastr.success('{{ session('success') }}', 'Succès', {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000"
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        $(document).ready(function() {
            toastr.error('{{ session('error') }}', 'Erreur', {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000"
            });
        });
    </script>
@endif

@endsection
