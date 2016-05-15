@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Editar Categoria: <strong>{!! $category->name !!}</strong></h1>

        @include('errors._check')

        {!! Form::model($category, ['route' => ['admin.categories.update', $category->id]]) !!}

            @include('admin.categories._form')

            <div class="form-group">
                {!! Form::submit('Salvar categoria', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection