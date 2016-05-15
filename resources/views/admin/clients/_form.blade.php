<div class="form-group">
    {!! Form::label('User', 'usuário') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control']) !!}
</div>


<div class="form-group">
    {!! Form::label('Phone', 'telefone') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Address', 'endereço') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('City', 'cidade') !!}
    {!! Form::text('city', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('State', 'state') !!}
    {!! Form::text('state', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Zipcode', 'cep') !!}
    {!! Form::text('zipcode', null, ['class' => 'form-control']) !!}
</div>