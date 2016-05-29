@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Cupoms</h1>
        <a href="{{route('admin.cupoms.create')}}" class="btn btn-default">Novo cupom</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            @foreach($cupoms as $cupom)
                <tr>
                    <td>{{$cupom->id}}</td>
                    <td>{{$cupom->code}}</td>
                    <td>{{$cupom->value}}</td>
                    <td>{{$cupom->status}}</td>
                    <td>
                        <a href="{{route('admin.cupoms.edit', ['id'=>$cupom->id])}}" class="btn btn-default btn-sm">Editar</a>
                        <a href="{{route('admin.cupoms.destroy', ['id'=>$cupom->id])}}" class="btn btn-default btn-sm">Excluir</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $cupoms->render() !!}
    </div>
@endsection