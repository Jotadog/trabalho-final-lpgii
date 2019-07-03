@extends('layouts.card')
@section('cardBody')
@section('title', 'Editar perfil')
<form method="POST" action="{{ route('profiles.update', $profile->id) }}" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label text-md-right">Nome</label>
        <div class="col-md-9">
            <input id="name" class="form-control" type="text" name="name" required value="{{ $profile->user->name }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-md-3 col-form-label text-md-right">E-mail</label>
        <div class="col-md-9">
            <input id="email" class="form-control" type="email" name="email" required
                value="{{ $profile->user->email }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="father_name" class="col-md-3 col-form-label text-md-right">Nome do pai</label>
        <div class="col-md-9">
            <input id="father_name" class="form-control" type="text" name="father_name" required
                value="{{ $profile->father_name }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="mother_name" class="col-md-3 col-form-label text-md-right">Nome da mãe</label>
        <div class="col-md-9">
            <input id="mother_name" class="form-control" type="text" name="mother_name" required
                value="{{ $profile->mother_name }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="date_of_birth" class="col-md-3 col-form-label text-md-right">Data de nascimento</label>
        <div class="col-md-9">
            <input id="date_of_birth" class="form-control" type="date" name="date_of_birth" required
                value="{{ $profile->date_of_birth }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="register" class="col-md-3 col-form-label text-md-right">Matrícula</label>
        <div class="col-md-9">
            <input id="register" class="form-control" type="text" name="register" required
                value="{{ $profile->register }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-md-3 col-form-label text-md-right">Endereço</label>
        <div class="col-md-9">
            <input id="address" class="form-control" type="text" name="address" required
                value="{{ $profile->address }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="cpf" class="col-md-3 col-form-label text-md-right">CPF</label>
        <div class="col-md-9">
            <input id="cpf" class="form-control" type="text" name="cpf" required value="{{ $profile->cpf }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="rg" class="col-md-3 col-form-label text-md-right">RG</label>
        <div class="col-md-9">
            <input id="rg" class="form-control" type="text" name="rg" required value="{{ $profile->rg }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="contact" class="col-md-3 col-form-label text-md-right">Contato</label>
        <div class="col-md-9">
            <input id="contact" class="form-control" type="text" name="contact" required
                value="{{ $profile->contact }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="photo" class="col-md-3 col-form-label text-md-right">Foto</label>
        <div class="col-md-9">
            <input id="photo" class="form-control-file" type="file" name="photo" />
        </div>
    </div>
    <div class="form-group row">
        <label for="role" class="col-md-3 col-form-label text-md-right">Papel</label>
        <div class="col-md-9">
            <select class="form-control" name="role_FK" id="role">
                <option value="2" {{ $profile->role->id == 2 ? "selected" : "" }}>Estudante</option>
                <option value="3" {{ $profile->role->id == 3 ? "selected" : "" }}>Professor</option>
            </select>
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-3">
            <button type="submit" class="btn btn-primary">
                Editar
            </button>
            <a class="btn btn-secondary" href="{{ route('home') }}">
                Voltar
            </a>
        </div>
    </div>
</form>
@endsection