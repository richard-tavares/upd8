@extends('layouts.app')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center text-center mt-5 pt-5">
    <img src="{{ asset('images/logo.png') }}" alt="Logo Upd8" height="100" class="mb-4">

    <h1 class="fw-bold mb-3">Bem-vindo ao Sistema :upd8</h1>

    <p class="lead mb-4">
        Uma aplicação web para gerenciamento de dados.<br>
        Desenvolvido com ❤️ utilizando Bootstrap 5 e Laravel 12.
    </p>
</div>
@endsection
