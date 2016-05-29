@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Editar cupom: <strong>#{!! $cupom->id !!}</strong></h1>

        @include('errors._check')

        {!! Form::model($cupom, ['route' => ['admin.cupoms.update', $cupom->id]]) !!}

            @include('admin.cupoms._form')

            <div class="form-group">
                {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection