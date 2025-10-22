@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Modification de année scolaire</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier l'année scolaire</h5>
                    <a class="btn btn-secondary float-end" href="{{route('annee.index')}}">retour</a>
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
                    <form action="{{route('annee.update', $annee->id )}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$annee->id}}">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Libelle</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$annee->libelle}}" name="libelle" placeholder="" />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection