@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Novo cliente</h1>

        @include('errors._check')

        {!! Form::open(['route' => 'admin.clients.store']) !!}

            @include('admin.clients._form')

            <div class="form-group">
                {!! Form::submit('Criar cliente', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection