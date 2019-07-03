@extends('layouts.card')
@section('cardBody')
@section('title')
{{ $title }}
@if($modify['create'])
<a href="{{ route($controller.'.create') }}" class="btn btn-success float-right">
    <i class="fas fa-plus"></i>
</a>
@endif
@endsection
<div class="table-responsive-lg text-center">
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
                    @if($key == 'id')
                        <th>{{ $datum->$key }}</th>
                    @else
                        <td>{{ $datum->$key }}</td>
                    @endif
                @endforeach
                <td>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-info" href="{{ route($controller.'.show', $datum->id) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($modify['edit'])
                            &nbsp;
                            <a class="btn btn-warning" href="{{ route($controller.'.edit', $datum->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endif
                        @if($modify['delete'])
                            &nbsp;
                            <form action="{{ route($controller.'.destroy', $datum->id) }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir')">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection