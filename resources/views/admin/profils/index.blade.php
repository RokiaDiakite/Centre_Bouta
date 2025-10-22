@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4>
        <img src="{{ $user->photo ?? asset('default-avatar.png') }}" alt="Photo" class="rounded-circle" width="40" height="40">
        👤 Mon profil
    </h4>
    <a class="btn btn-secondary float-end" href="{{route('admin.dashboard')}}">Retour</a>
    


    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p><strong>Nom :</strong> {{ $user->nom }}</p>
    <p><strong>Prénom :</strong> {{ $user->prenom }}</p>
    <p><strong>Username :</strong> {{ $user->username }}</p>
    <p><strong>Email :</strong> {{ $user->email }}</p>

    <a href="{{ route('admin.profile.show') }}" class="btn btn-primary">✏️ Modifier mon profil</a>
</div>
@endsection