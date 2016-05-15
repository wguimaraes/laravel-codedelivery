@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Pedidos</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Nome</th>
                    <th>Endereço do cliente</th>
                    <th>Entregador</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->client->user->name}}</td>
                    <td>{{$order->client->address}}</td>
                    <td>
                        @if($order->delivaryMan)
                            {{$order->delivaryMan->name}}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($order->status == 1)
                            Solicitado
                        @elseif($order->status == 2)
                            Em transporte
                        @elseif($order->status == 3)
                            Entregue
                        @elseif($order->status == 4)
                            Cancelado
                        @endif
                    </td>
                    <td>{{$order->total}}</td>
                    <td>
                        <a href="{{route('admin.orders.edit', ['id'=>$order->id])}}" class="btn btn-default btn-sm">Editar</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$orders->render()}}
    </div>
@endsection