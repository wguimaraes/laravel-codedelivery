@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Editar Cliente</h1>

        @include('errors._check')

        {!! Form::model($client, ['route' => ['admin.clients.update', $client->id]]) !!}

            @include('admin.clients._form')

            <div class="form-group">
                {!! Form::submit('Salvar cliente', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection