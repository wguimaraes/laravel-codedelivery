@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Editar Produto: <strong>{!! $product->name !!}</strong></h1>

        @include('errors._check')

        {!! Form::model($product, ['route' => ['admin.products.update', $product->id]]) !!}

            @include('admin.products._form')

            <div class="form-group">
                {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection