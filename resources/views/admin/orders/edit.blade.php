@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Editar Pedido: <strong>{!! $order->name !!}</strong></h1>

        @include('errors._check')

        {!! Form::model($order, ['route' => ['admin.orders.update', $order->id]]) !!}

            @include('admin.orders._form')

            <div class="form-group">
                {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection