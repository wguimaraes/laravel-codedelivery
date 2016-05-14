@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Nova Categoria</h1>

        {!! Form::open(['route' => 'admin.categories.store']) !!}

            <div class="form-group">
                {!! Form::label('Name', 'nome') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection