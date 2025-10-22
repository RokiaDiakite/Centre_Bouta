@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Ajouter un maitre</h4>

  <!-- Basic Layout & Basic with Icons -->
  <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
      <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">ajout d'un maitre'</h5>
          <a class="btn btn-secondary float-end" href="{{route('maitre.index')}}">retour</a>
        </div>
        @if($errors->any())
        <div class="alert alert-danger">
          <ul>

            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>

            @endforeach
          </ul>
        </div>

        @endif

        <div class="card-body">
          <form action="{{route('maitre.store')}}" method="POST">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nom</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" name="nom" placeholder="" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Prenom</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" name="prenom" placeholder="" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Numero</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" name="numero" placeholder="" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Salaire</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" name="salaire" placeholder="" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Adresse</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" name="adresse" placeholder="" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nom Utilisateur</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" name="username" placeholder="" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" name="email" placeholder="" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Password</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" name="password" placeholder="" required>
              </div>
            </div>
            <div class="row justify-content-end">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection