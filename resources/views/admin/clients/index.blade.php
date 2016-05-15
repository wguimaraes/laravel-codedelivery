@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Clientes</h1>
        <a href="{{route('admin.clients.create')}}" class="btn btn-default">Novo cliente</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Endereço</th>
                    <th>Cidade</th>
                    <th>Telefone</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{$client->id}}</td>
                    <td>{{$client->user->name}}</td>
                    <td>{{$client->address}}</td>
                    <td>{{$client->city}}</td>
                    <td>{{$client->phone}}</td>
                    <td>
                        <a href="{{route('admin.clients.edit', ['id'=>$client->id])}}" class="btn btn-default btn-sm">Editar</a>
                        <a href="{{route('admin.clients.destroy', ['id'=>$client->id])}}" class="btn btn-default btn-sm">Excluir</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$clients->render()}}
    </div>
@endsection