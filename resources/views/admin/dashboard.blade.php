@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

@if(session('success'))
<div class="alert alert-success mt-2">
    {{ session('success') }}
</div>
@endif

@endsection