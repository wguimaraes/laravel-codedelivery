<div class="form-group">
    {!! Form::label('Client', 'Cliente') !!}:
    {!! $order->client->user->name !!}
</div>

<div class="form-group">
    {!! Form::label('Endereço', 'Endereço') !!}:
    {!! $order->client->address !!}
</div>

<div class="form-group">
    {!! Form::label('DeliveryMan', 'Entregador') !!}
    {!! Form::select('deliveryman_id', $users, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Status', 'Status') !!}
    {!! Form::select('status', $status, null, ['class' => 'form-control']) !!}
</div>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>Ítem</th>
        <th>Preço</th>
        <th>Quantidade</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->items as $item)
        <tr>
            <td>{{$item->product->name}}</td>
            <td>{{$item->price}}</td>
            <td><span>{{$item->qtd}}</span></td>
        </tr>
    @endforeach
    </tbody>
</table>