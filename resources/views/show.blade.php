@extends('layouts.card')
@section('cardBody')
@section('title', $title)
@csrf
@foreach ($fields as $key => $value)
<div class="form-group row">
    <label for="{{ $key }}" class="col-md-3 col-form-label text-md-right">{{ $value['name'] }}</label>
    <div class="col-md-9">
        <input id="{{ $key }}" class="form-control" type="{{ $value['type'] ?? 'text' }}" name="{{ $key }}" required
            disabled value="{{ $datum->$key }}" />
    </div>
</div>
@endforeach
<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-3">
        <a href="{{ route($controller.'.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </div>
</div>
@endsection