@extends('layouts.card')
@section('cardBody')
@section('title', 'Editar perfil')
<form method="POST" action="{{ route('profiles.update', $profile->id) }}" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label text-md-right">{{ $value['name'] }}</label>
        <div class="col-md-9">
            <input id="name" class="form-control" type="text" name="nome" required value="{{ $datum->$key }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="{{ $key }}" class="col-md-3 col-form-label text-md-right">{{ $value['name'] }}</label>
        <div class="col-md-9">
            <input id="{{ $key }}" class="form-control" type="{{ $value['type'] ?? 'text' }}" name="{{ $key }}" required
                value="{{ $datum->$key }}" />
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-3">
            <button type="submit" class="btn btn-primary">
                Editar
            </button>
            <a class="btn btn-primary" href="{{ route($controller.'.index') }}">
                Voltar
            </a>
        </div>
    </div>
</form>
@endsection