@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Meus pedidos</h1>
        <a href="{{route('customer.order.create')}}" class="btn btn-default">Novo pedido</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->total}}</td>
                    <td>{{$order->status}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {!! $orders->render() !!}
    </div>
@endsection