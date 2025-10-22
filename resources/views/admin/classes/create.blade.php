@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Ajouter une classe</h4>

  <!-- Basic Layout & Basic with Icons -->
  <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
      <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">ajout d'une classe</h5>
          <a class="btn btn-secondary float-end" href="{{route('classe.index')}}">retour</a>
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
          <form action="{{route('classe.store')}}" method="POST">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nom</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" name="nom" placeholder="" />
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label>Niveau</label>
              <select name="niveau" class="form-control" required>
                <option value="">-- Sélectionnez --</option>
                <option value="Maternelle">Maternelle</option>
                <option value="Premier cycle">Premier cycle</option>
                <option value="Second cycle">Second cycle</option>
              </select>
            </div>

        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Frais Scolaire</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="basic-default-name" name="frais" placeholder="" />
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