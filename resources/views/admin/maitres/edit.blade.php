@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Modification de maitre</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier un maitre</h5>
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
                    <form action="{{route('maitre.update', $maitre->id )}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$maitre->id}}">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nom</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$maitre->nom}}" name="nom" placeholder="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Prenom</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$maitre->prenom}}" name="prenom" placeholder="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Numero</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$maitre->numero}}" name="numero" placeholder="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Salaire</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$maitre->salaire}}" name="salaire" placeholder="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Adresse</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$maitre->adresse}}" name="adresse" placeholder="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nom Utilisateur</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$maitre->username}}" name="username" placeholder="" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$maitre->email}}" name="email" placeholder="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Password</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$maitre->password}}" name="password" placeholder="" />
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