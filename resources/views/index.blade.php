@extends('layouts.card')
@section('cardBody')
@section('title', $title)
<a href="{{ route($controller.'.create') }}" class="btn btn-success float-right">
    <i class="fas fa-plus"></i>
</a>
<table class="table">
    <thead>
        <tr>
        @foreach ($fields as $key => $value)
            <th scope="col">{{ $value }}</th>
        @endforeach
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
    
        @foreach ($data as $datum)
        <tr>
            @foreach ($fields as $key => $field)
                <th>{{ $datum->$key }}</th>
            @endforeach
            <td>
                <div class="row">
                    <a class="btn btn-success" href="{{ route($controller.'.show', $datum->id) }}">
                        <i class="fas fa-eye"></i>
                    </a>
                    &nbsp;
                    <a class="btn btn-warning" href="{{ route($controller.'.edit', $datum->id) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    &nbsp;
                    <form action="{{ route($controller.'.destroy', $datum->id) }}" method="POST"
                        onsubmit="return confirm('Tem certeza que deseja excluir')">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection