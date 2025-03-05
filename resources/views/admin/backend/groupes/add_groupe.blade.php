@extends('admin.admin_dashboard') {{-- Assurez-vous que ce fichier existe --}}
@section('admin')

<div class="container">
    <h2>Créer un Groupe</h2>

    {{-- Vérifier s'il y a des erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('store.group') }}" method="POST"> {{-- Correction de la route --}}
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du Groupe</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>

@endsection
