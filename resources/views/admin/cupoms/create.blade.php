@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Novo Cupom</h1>

        @include('errors._check')

        {!! Form::model($cupom, ['route' => 'admin.cupoms.store']) !!}

            @include('admin.cupoms._form')

            <div class="form-group">
                {!! Form::submit('Criar cupom', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection