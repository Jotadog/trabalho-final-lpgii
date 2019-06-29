@extends('layouts.card')
@section('cardBody')
@section('title', $title)
<form method="POST" action="{{ route($controller.'.update', $datum->id) }}" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    @foreach ($fields as $key => $value)
        @if(isset($value['select']))
            @foreach ($datum as $keyDatum => $valueDatum)
                @if ($key == $keyDatum)
                <div class="form-group row">
                    <label for="{{ $key }}" class="col-md-3 col-form-label text-md-right">{{ $value['name'] }}</label>
                    <div class="col-md-9">
                        <select name="{{ $keyDatum }}" class="custom-select">
                            @foreach ($valueDatum as $valueField)
                                <option value="{{ $valueField['value'] }}">{{ $valueField['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
            @endforeach
        @else
            <div class="form-group row">
                <label for="{{ $key }}" class="col-md-3 col-form-label text-md-right">{{ $value['name'] }}</label>
                <div class="col-md-9">
                    <input id="{{ $key }}" class="form-control" type="{{ $value['type'] ?? 'text' }}" name="{{ $key }}" required value="{{ $datum->$key }}" />
                </div>
            </div>
        @endif
    @endforeach
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