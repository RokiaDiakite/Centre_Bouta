@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span>Evaluation</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="display-flex justify-content-between">
            <h5 class="card-header">Liste des evaluations</h5>
            <a class="btn btn-primary" href="{{route('evaluation.create')}}">Ajouter</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($evaluations as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$data->nom}}</strong></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('evaluation.edit', $data->id) }}"><i class="bx bx-edit-alt me-1"></i> Modifier</a>
                                    <form action="{{ route('evaluation.delete', $data->id) }}" method="POST" style="display:inline-block">

                                        @csrf

                                        
                                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ?')" class="btn btn-danger btn-sm"><i class="bx bx-trash me-1"></i>Supprimer</button>
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
    <!--/ Basic Bootstrap Table -->
</div>
@endsection