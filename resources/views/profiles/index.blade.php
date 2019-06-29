@extends('layouts.card')
@section('title', 'Perfis')
@section('cardBody')
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
            <th scope="col">Status do perfil</th>
            <th scope="col">Aprovar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($profiles as $profile)
        <tr>
            <th scope="row">{{ $profile->id }}</th>
            <td>{{ $profile->user->name }}</td>
            <td>{{ $profile->user->email }}</td>
            <td>{{ $profile->status }}</td>
            <td>
                @if($profile->status == "Pendente")
                <form action="{{ route('profiles.approveProfile', $profile->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">Aprovar</button>
                </form>
                @else
                <button type="submit" class="btn btn-success"
                    onclick="return alert('Esse cara ja foi aprovado, seu animal')">Aprovado</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection