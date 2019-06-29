@extends('layouts.card')
@section('cardBody')
@section('title', 'Usuários')
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
            <th scope="col">Aprovação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if ($user->id != auth()->user()->id)
                <form action="{{ route('users.store') }}" method="POST">
                    <div class="row">
                        @csrf
                        <div class="col-md-8">
                            <div class="form-group">
                                <select name="aprovacao" id="aprovacao" class="form-control">
                                    <option value="1">Aprovado</option>
                                    <option value="0">Não aprovado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection